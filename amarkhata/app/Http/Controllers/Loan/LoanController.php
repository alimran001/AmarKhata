<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function __construct()
    {
        // Remove the middleware from the constructor
    }
    
    public function index(Request $request)
    {
        $query = Loan::where('user_id', Auth::id());
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('is_settled')) {
            $query->where('is_settled', $request->is_settled === '1');
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('person_name', 'like', '%' . $request->search . '%')
                  ->orWhere('note', 'like', '%' . $request->search . '%');
            });
        }
        
        $loans = $query->orderBy('is_settled')
            ->orderBy('due_date')
            ->paginate(15)
            ->withQueryString();
            
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        return view('loans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'person_name' => 'required|string|max:255',
            'type' => 'required|in:Given,Taken',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'nullable|date',
            'note' => 'nullable|string|max:1000',
            'is_settled' => 'nullable|boolean',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        // Set default values for remaining amount based on is_settled
        $validated['remaining'] = $validated['is_settled'] ?? false ? 0 : $validated['amount'];
        $validated['is_settled'] = $validated['is_settled'] ?? false;
        
        Loan::create($validated);
        
        return redirect()->route('loans.index')
            ->with('success', 'লোন সফলভাবে যোগ করা হয়েছে।');
    }

    public function show(Loan $loan)
    {
        $this->authorize('view', $loan);
        
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $this->authorize('update', $loan);
        
        return view('loans.edit', compact('loan'));
    }

    public function update(Request $request, Loan $loan)
    {
        $this->authorize('update', $loan);
        
        $validated = $request->validate([
            'person_name' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'note' => 'nullable|string|max:1000',
            'remaining' => 'nullable|numeric|min:0|max:' . $loan->amount,
            'is_settled' => 'nullable|boolean',
        ]);
        
        // Cannot change the amount or type after creation
        
        if (isset($validated['is_settled']) && $validated['is_settled']) {
            $validated['remaining'] = 0;
        }
        
        $loan->update($validated);
        
        return redirect()->route('loans.index')
            ->with('success', 'Loan record updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        $this->authorize('delete', $loan);
        
        $loan->delete();
        
        return redirect()->route('loans.index')
            ->with('success', 'Loan record deleted successfully.');
    }
    
    public function paymentForm(Loan $loan)
    {
        $this->authorize('update', $loan);
        
        return view('loans.payment', compact('loan'));
    }
    
    public function recordPayment(Request $request, Loan $loan)
    {
        $this->authorize('update', $loan);
        
        $validated = $request->validate([
            'payment_amount' => 'required|numeric|min:0.01|max:' . $loan->remaining,
        ]);
        
        $loan->remaining -= $validated['payment_amount'];
        
        if ($loan->remaining <= 0) {
            $loan->is_settled = true;
            $loan->remaining = 0;
        }
        
        $loan->save();
        
        return redirect()->route('loans.show', $loan)
            ->with('success', 'Payment recorded successfully.');
    }
}
