<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanInstallment;

class LoanInstallmentController extends Controller
{
    public function index()
    {
        $installments = LoanInstallment::with('loan')->get();
        return view('admin.loan_installments.index', compact('installments'));
    }

    public function show(LoanInstallment $loanInstallment)
    {
        return view('admin.loan_installments.show', compact('loanInstallment'));
    }

    public function edit(LoanInstallment $loanInstallment)
    {
        return view('admin.loan_installments.edit', compact('loanInstallment'));
    }

    public function update(Request $request, LoanInstallment $loanInstallment)
    {
        $request->validate(['amount' => 'required|numeric']);
        $loanInstallment->update($request->all());
        return redirect()->route('loan_installments.index')->with('success', 'Installment updated');
    }

    public function destroy(LoanInstallment $loanInstallment)
    {
        $loanInstallment->delete();
        return redirect()->route('loan_installments.index')->with('success', 'Installment deleted');
    }
}
