@extends('admin.index')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Breadcrumb & Back Button -->
        <div class="sm:p-6 mb-6">
            <div class="flex items-center justify-between">

                <!-- Breadcrumb Left (unchanged) -->
                <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                    <a href="{{ route('savings.index') }}"
                        class="flex items-center text-primary-500 hover:text-primary-600 transition">
                        <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                        Savings
                    </a>
                    <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                    <span>Create Savings Transaction</span>
                </nav>

                <!-- Small Back Button Right -->
                <a href="{{ route('savings.index') }}"
                    class="btn btn-secondary flex items-center px-3 py-1 text-sm rounded-md font-medium hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <iconify-icon icon="heroicons-outline:arrow-left" class="mr-1 w-4 h-4"></iconify-icon>
                    Back
                </a>

            </div>
        </div>

        <!-- Modern Card Form -->
        <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-6 sm:p-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Edit Savings Transaction</h2>

            <form action="{{ route('savings.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Member Select -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Member</label>
                    <select name="member_id"
                        class="form-control w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:outline-none dark:bg-slate-700 dark:text-slate-200"
                        required>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type Select -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                    <select name="type"
                        class="form-control w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:outline-none dark:bg-slate-700 dark:text-slate-200">
                        <option value="deposit" {{ old('type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                        <option value="withdraw" {{ old('type') == 'withdraw' ? 'selected' : '' }}>Withdraw</option>
                    </select>
                </div>

                <!-- Amount Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" required
                        class="form-control w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:outline-none dark:bg-slate-700 dark:text-slate-200">
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-md font-medium transition-colors">
                        Save
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
