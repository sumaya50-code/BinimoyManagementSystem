@extends('admin.index')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Breadcrumb & Back Button -->
        <div class="sm:p-6 mb-6">
            <div class="flex items-center justify-between">

                <!-- Breadcrumb Left -->
                <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                    <a href="{{ route('members.index') }}"
                        class="flex items-center text-primary-500 hover:text-primary-600 transition">
                        <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                        Savings
                    </a>
                    <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                    <span>Edit Savings Transaction</span>
                </nav>

                <!-- Small Back Button Right -->
                <a href="{{ route('savings.index') }}"
                    class="btn btn-secondary flex items-center px-3 py-1 text-sm rounded-md font-medium hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <iconify-icon icon="heroicons-outline:arrow-left" class="mr-1 w-4 h-4"></iconify-icon>
                    Back
                </a>

            </div>
        </div>




        <!-- Card Container -->
        <div class="bg-white dark:bg-slate-800 shadow-md rounded-xl p-6 sm:p-8">
            <h3 class="text-xl font-semibold text-slate-800 dark:text-white mb-6">Edit Savings Transaction</h3>

            <form action="{{ route('savings.update', $transaction->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Type Field -->
                <div>
                    <label for="type"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Transaction Type</label>
                    <select name="type" id="type"
                        class="form-select w-full border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-slate-700">
                        <option value="deposit" {{ $transaction->type == 'deposit' ? 'selected' : '' }}>Deposit</option>
                        <option value="withdraw" {{ $transaction->type == 'withdraw' ? 'selected' : '' }}>Withdraw</option>
                    </select>
                    @error('type')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Amount Field -->
                <div>
                    <label for="amount"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Amount</label>
                    <input type="number" name="amount" id="amount" value="{{ $transaction->amount }}"
                        class="form-input w-full border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-slate-700">
                    @error('amount')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="btn btn-success bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg font-medium transition">
                        Update Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
