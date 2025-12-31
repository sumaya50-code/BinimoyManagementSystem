@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">New Collection</h2>
    <form action="{{ route('loan.collections.store') }}" method="POST">
        @csrf
        <div>
            <label>Installment</label>
            <select name="loan_installment_id" required>
                <option value="">Select Installment</option>
                @foreach(App\Models\LoanInstallment::with('loan')->where('status','pending')->get() as $inst)
                    <option value="{{ $inst->id }}">Loan #{{ $inst->loan->id ?? 'N/A' }} - Installment {{ $inst->installment_no }} - Due {{ $inst->due_date }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Amount</label>
            <input type="number" name="amount" step="0.01" required />
        </div>
        <div>
            <label>Remarks</label>
            <input name="remarks" />
        </div>
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
</div>
@endsection
