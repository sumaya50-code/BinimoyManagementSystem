@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Collection #{{ $loanCollection->id }}</h2>

    <div class="card p-4">
        <p><strong>Loan:</strong> {{ $loanCollection->installment->loan->id ?? '-' }}</p>
        <p><strong>Installment:</strong> {{ $loanCollection->installment->installment_no ?? '-' }} (Due {{ $loanCollection->installment->due_date ?? '-' }})</p>
        <p><strong>Amount:</strong> {{ $loanCollection->amount }}</p>
        <p><strong>Status:</strong> {{ $loanCollection->status }}</p>
        <p><strong>Collector:</strong> {{ $loanCollection->collector->name ?? '-' }}</p>
        <p><strong>Remarks:</strong> {{ $loanCollection->remarks ?? '-' }}</p>

        @if($loanCollection->status == 'pending')
            <form action="{{ route('loan.collections.verify', $loanCollection->id) }}" method="POST" class="mt-4">
                @csrf
                <button class="btn btn-primary">Verify</button>
            </form>
        @endif
    </div>
</div>
@endsection
