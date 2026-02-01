<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function __construct()
    {
        // Remove the middleware from the constructor
    }
    
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id())
            ->with(['account', 'category', 'transferToAccount']);
        
        // Apply filters if provided
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('account_id')) {
            $query->where(function($q) use ($request) {
                $q->where('account_id', $request->account_id)
                  ->orWhere('transfer_to_account_id', $request->account_id);
            });
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }
        
        if ($request->filled('search')) {
            $query->where('note', 'like', '%'.$request->search.'%');
        }
        
        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $accounts = Account::where('user_id', Auth::id())->get();
        $categories = Category::where('user_id', Auth::id())->get();
        
        return view('transactions.index', compact('transactions', 'accounts', 'categories'));
    }

    public function create()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();
        $incomeCategories = Category::where('user_id', Auth::id())
            ->where('type', 'income')
            ->get();
            
        return view('transactions.create', compact('accounts', 'categories', 'incomeCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense,transfer',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'transfer_to_account_id' => 'required_if:type,transfer|exists:accounts,id',
            'note' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Handle attachment upload
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('transactions', 'public');
                $validated['attachment'] = $attachmentPath;
            }
            
            $validated['user_id'] = Auth::id();
            
            // Save transaction
            $transaction = Transaction::create($validated);
            
            // Update account balance
            $account = Account::findOrFail($validated['account_id']);
            
            if ($validated['type'] === 'income') {
                $account->current_balance += $validated['amount'];
            } elseif ($validated['type'] === 'expense') {
                $account->current_balance -= $validated['amount'];
            } elseif ($validated['type'] === 'transfer') {
                $account->current_balance -= $validated['amount'];
                
                $toAccount = Account::findOrFail($validated['transfer_to_account_id']);
                $toAccount->current_balance += $validated['amount'];
                $toAccount->save();
            }
            
            $account->save();
            
            DB::commit();
            
            return redirect()->route('transactions.index')
                ->with('success', 'লেনদেন সফলভাবে রেকর্ড করা হয়েছে।');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'লেনদেন ব্যর্থ হয়েছে: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $accounts = Account::where('user_id', Auth::id())->get();
        $categories = Category::where('user_id', Auth::id())->get();
        
        return view('transactions.edit', compact('transaction', 'accounts', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'note' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'amount' => 'sometimes|required|numeric|min:0.01',
        ]);
        
        // Restricting updates to just category, note, amount and attachment
        // to maintain financial integrity
        
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($transaction->attachment) {
                Storage::disk('public')->delete($transaction->attachment);
            }
            
            $attachmentPath = $request->file('attachment')->store('transactions', 'public');
            $validated['attachment'] = $attachmentPath;
        }
        
        // পরিমাণ পরিবর্তন হলে হিসাবের ব্যালেন্স আপডেট করা
        if ($request->filled('amount') && $transaction->amount != $request->amount) {
            DB::beginTransaction();
            
            try {
                // হিসাব নিয়ে আসা
                $account = $transaction->account;
                
                // আগের পরিমাণের প্রভাব উল্টে দেওয়া
                if ($transaction->type === 'income') {
                    $account->current_balance -= $transaction->amount;
                    $account->current_balance += $request->amount;
                } else if ($transaction->type === 'expense') {
                    $account->current_balance += $transaction->amount;
                    $account->current_balance -= $request->amount;
                }
                
                $account->save();
                
                // ট্রানজেকশন আপডেট
                $transaction->update($validated);
                
                DB::commit();
                
                return redirect()->route('transactions.show', $transaction)
                    ->with('success', 'লেনদেন সফলভাবে আপডেট করা হয়েছে।');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'লেনদেন আপডেট ব্যর্থ হয়েছে: ' . $e->getMessage()])
                    ->withInput();
            }
        } else {
            // শুধু ট্রানজেকশন আপডেট করা
            $transaction->update($validated);
            
            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'লেনদেন সফলভাবে আপডেট করা হয়েছে।');
        }
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        
        DB::beginTransaction();
        
        try {
            $account = $transaction->account;
            
            // Reverse the transaction effect on account balance
            if ($transaction->type === 'income') {
                $account->current_balance -= $transaction->amount;
            } elseif ($transaction->type === 'expense') {
                $account->current_balance += $transaction->amount;
            } elseif ($transaction->type === 'transfer') {
                $account->current_balance += $transaction->amount;
                
                $toAccount = $transaction->transferToAccount;
                if ($toAccount) {
                    $toAccount->current_balance -= $transaction->amount;
                    $toAccount->save();
                }
            }
            
            $account->save();
            
            // Delete attachment if exists
            if ($transaction->attachment) {
                Storage::disk('public')->delete($transaction->attachment);
            }
            
            $transaction->delete();
            
            DB::commit();
            
            return redirect()->route('transactions.index')
                ->with('success', 'লেনদেন সফলভাবে মুছে ফেলা হয়েছে।');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'মুছে ফেলা ব্যর্থ হয়েছে: ' . $e->getMessage()]);
        }
    }
    
    public function quickAdd(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'category_name' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:255',
            'transaction_date' => 'nullable|date',
        ]);
        
        $validated['user_id'] = Auth::id();
        $validated['date'] = $request->filled('transaction_date') ? $request->transaction_date : Carbon::now()->toDateString();
        
        // যদি category_id না থাকে কিন্তু category_name থাকে
        if (!$request->filled('category_id') && $request->filled('category_name')) {
            // প্রথমে ইউজারের বিদ্যমান ক্যাটেগরি খুঁজে দেখা
            $category = Category::where('user_id', Auth::id())
                ->where('name', $request->category_name)
                ->where('type', $request->type)
                ->first();
            
            // যদি ক্যাটেগরি না থাকে তবে নতুন ক্যাটেগরি তৈরি করা
            if (!$category) {
                $category = Category::create([
                    'user_id' => Auth::id(),
                    'name' => $request->category_name,
                    'type' => $request->type,
                    'color' => $request->type === 'income' ? '#4CAF50' : '#F44336', // ডিফল্ট কালার
                    'icon' => $request->type === 'income' ? 'fa-money-bill' : 'fa-shopping-bag', // ডিফল্ট আইকন
                ]);
            }
            
            $validated['category_id'] = $category->id;
        }
        // যদি category_id থাকে তবে নিশ্চিত করা যে এটি সঠিক টাইপের ক্যাটেগরি
        else if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            
            // যদি ক্যাটেগরি পাওয়া যায় এবং এর টাইপ লেনদেনের টাইপের সাথে না মিলে
            if ($category && $category->type !== $request->type) {
                // সঠিক টাইপের একই নামের ক্যাটেগরি খুঁজা
                $correctCategory = Category::where('user_id', Auth::id())
                    ->where('name', $category->name)
                    ->where('type', $request->type)
                    ->first();
                
                // যদি সঠিক টাইপের ক্যাটেগরি না থাকে তবে তৈরি করা
                if (!$correctCategory) {
                    $correctCategory = Category::create([
                        'user_id' => Auth::id(),
                        'name' => $category->name,
                        'type' => $request->type,
                        'color' => $request->type === 'income' ? '#4CAF50' : '#F44336',
                        'icon' => $request->type === 'income' ? 'fa-money-bill' : 'fa-shopping-bag',
                    ]);
                }
                
                $validated['category_id'] = $correctCategory->id;
            }
        }
        
        DB::beginTransaction();
        
        try {
            // Create transaction
            $transaction = Transaction::create($validated);
            
            // Update account balance
            $account = Account::findOrFail($validated['account_id']);
            
            if ($validated['type'] === 'income') {
                $account->current_balance += $validated['amount'];
            } else {
                $account->current_balance -= $validated['amount'];
            }
            
            $account->save();
            
            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'লেনদেন সফলভাবে যোগ করা হয়েছে']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'লেনদেন যোগ করতে সমস্যা হয়েছে: ' . $e->getMessage()], 500);
        }
    }
}
