@extends('admin.partials.index')

@section('content')
<div class="sm:p-6 mb-6">
    <h2 class="text-xl font-semibold">Loan Details</h2>
</div>

<div class="card shadow-md rounded-xl p-6 space-y-3">
    <p><strong>Member:</strong> {{ $loan->member->name }}</p>
    <p><strong>Amount:</strong> {{ $loan->loan_amount }}</p>
    <p><strong>Interest:</strong> {{ $loan->interest_rate }}%</p>
    <p><strong>Installments:</strong> {{ $loan->installment_count }}</p>
    <p><strong>Type:</strong> {{ ucfirst($loan->installment_type) }}</p>
    <p><strong>Status:</strong> {{ $loan->status }}</p>
    <p><strong>Remarks:</strong> {{ $loan->remarks }}</p>
</div>
@endsection
