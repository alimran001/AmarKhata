<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct()
    {
        // Remove the middleware from the constructor
    }
    
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'initial_balance' => 'required|numeric|min:0',
            'account_number' => 'nullable|string|max:100',
        ]);

        // চেক করি এটি ডিফল্ট অ্যাকাউন্ট কিনা
        $defaultAccountNames = ['Cash In Hand (হাতে)', 'My Bank', 'বিকাশ', 'Nagad', 'Rocket', 'Others'];
        if (in_array($validated['name'], $defaultAccountNames)) {
            return back()->withErrors(['name' => 'এই নামটি ডিফল্ট অ্যাকাউন্টের জন্য সংরক্ষিত। অন্য নাম ব্যবহার করুন।']);
        }

        $validated['user_id'] = Auth::id();
        $validated['current_balance'] = $validated['initial_balance'];
        $validated['is_default'] = false;

        Account::create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'হিসাব সফলভাবে তৈরি করা হয়েছে।');
    }

    public function show(Account $account)
    {
        $this->authorize('view', $account);
        
        $transactions = $account->transactions()
            ->with('category')
            ->orderBy('date', 'desc')
            ->paginate(15);
            
        return view('accounts.show', compact('account', 'transactions'));
    }

    public function edit(Account $account)
    {
        $this->authorize('update', $account);
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'account_number' => 'nullable|string|max:100',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'হিসাব সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);
        
        // Check if account has any transactions
        if ($account->transactions()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete account with transactions. Please delete the transactions first or transfer them to another account.']);
        }
        
        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Account deleted successfully.');
    }
}
