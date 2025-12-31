@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Installment #{{ $loanInstallment->id }}</h2>
    <div class="card p-4">
        <p><strong>Loan:</strong> {{ $loanInstallment->loan->id ?? '-' }}</p>
        <p><strong>Installment No:</strong> {{ $loanInstallment->installment_no }}</p>
        <p><strong>Due Date:</strong> {{ $loanInstallment->due_date }}</p>
        <p><strong>Amount:</strong> {{ $loanInstallment->amount }}</p>
        <p><strong>Paid Amount:</strong> {{ $loanInstallment->paid_amount }}</p>
        <p><strong>Penalty:</strong> {{ $loanInstallment->penalty_amount }}</p>
        <p><strong>Status:</strong> {{ $loanInstallment->status }}</p>
    </div>
</div>
@endsection