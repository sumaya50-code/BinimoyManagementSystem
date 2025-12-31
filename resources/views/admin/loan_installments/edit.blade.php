@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Edit Installment #{{ $loanInstallment->id }}</h2>
    <form action="{{ route('loan_installments.update', $loanInstallment->id) }}" method="POST">
        @csrf @method('PUT')
        <div>
            <label>Amount</label>
            <input type="number" name="amount" value="{{ $loanInstallment->amount }}" step="0.01" required>
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="pending" {{ $loanInstallment->status=='pending' ? 'selected':'' }}>Pending</option>
                <option value="paid" {{ $loanInstallment->status=='paid' ? 'selected':'' }}>Paid</option>
                <option value="overdue" {{ $loanInstallment->status=='overdue' ? 'selected':'' }}>Overdue</option>
            </select>
        </div>
        <button class="btn btn-primary mt-2">Update</button>
    </form>
</div>
@endsection