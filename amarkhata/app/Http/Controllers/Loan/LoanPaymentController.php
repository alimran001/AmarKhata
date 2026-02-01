<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Http\Request;

class LoanPaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:255'
        ]);

        $loan = Loan::findOrFail($request->loan_id);
        
        // চেক করি লোনটি বর্তমান ইউজারের কিনা
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        // চেক করি বাকি পরিমাণের চেয়ে বেশি পেমেন্ট করা হচ্ছে কিনা
        $remainingAmount = $loan->amount - $loan->paid_amount;
        if ($request->amount > $remainingAmount) {
            return back()->withErrors(['amount' => 'পেমেন্টের পরিমাণ বাকি পরিমাণের চেয়ে বেশি হতে পারবে না']);
        }

        $payment = LoanPayment::create([
            'loan_id' => $loan->id,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes
        ]);

        // লোনের paid_amount আপডেট করি
        $loan->paid_amount += $request->amount;
        if ($loan->paid_amount >= $loan->amount) {
            $loan->is_settled = true;
        }
        $loan->save();

        return redirect()->back()->with('success', 'পেমেন্ট সফলভাবে সংরক্ষণ করা হয়েছে');
    }

    public function destroy(LoanPayment $payment)
    {
        // চেক করি পেমেন্টটি বর্তমান ইউজারের কিনা
        if ($payment->loan->user_id !== auth()->id()) {
            abort(403);
        }

        $loan = $payment->loan;
        
        // লোনের paid_amount আপডেট করি
        $loan->paid_amount -= $payment->amount;
        if ($loan->paid_amount < $loan->amount) {
            $loan->is_settled = false;
        }
        $loan->save();

        $payment->delete();

        return redirect()->back()->with('success', 'পেমেন্ট রেকর্ড সফলভাবে মুছে ফেলা হয়েছে');
    }
} 