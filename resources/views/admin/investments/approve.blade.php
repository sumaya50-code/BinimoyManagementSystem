@extends('admin.partials.index')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('investments.index') }}" class="text-primary-500 hover:text-primary-600 flex items-center">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Investments
            </a>
            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
            <span class="text-slate-600 dark:text-slate-300">Approve Investment Application</span>
        </nav>
    </div>

    <div class="card shadow-md rounded-xl">
        <div class="card-header bg-slate-100 dark:bg-slate-800 px-6 py-4">
            <h4 class="card-title">Approve Investment Application</h4>
        </div>
        <div class="card-body p-6">
            <div class="mb-4">
                <h5>Application Details</h5>
                <p><strong>Investment No:</strong> {{ $investment->investment_no }}</p>
                <p><strong>Applicant:</strong>
                    {{ $investment->member ? $investment->member->name : $investment->partner->name }}</p>
                <p><strong>Applied Amount:</strong> ৳{{ number_format($investment->applied_amount, 2) }}</p>
                <p><strong>Business Name:</strong> {{ $investment->business_name }}</p>
            </div>

            <form action="{{ route('investments.approve', $investment->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="approved_amount"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300">Approved Amount</label>
                        <input type="number" name="approved_amount" id="approved_amount" class="form-control mt-1"
                            step="0.01" max="{{ $investment->applied_amount }}" required>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('investments.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Approve Application</button>
                </div>
            </form>
        </div>
    </div>
@endsection
