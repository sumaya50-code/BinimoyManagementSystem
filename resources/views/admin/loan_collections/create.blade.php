@extends('admin.partials.index')

@section('content')
    <div class="space-y-6 p-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-50 rounded-lg">
                    <iconify-icon icon="heroicons-outline:plus-circle" class="text-blue-600 text-xl"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Create New Collection</h1>
                    <p class="text-slate-600">Record a new loan payment collection</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form action="{{ route('loan.collections.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Installment Field -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            <iconify-icon icon="heroicons-outline:document-text"
                                class="inline mr-2 text-slate-500"></iconify-icon>
                            Installment
                        </label>
                        <select name="loan_installment_id" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Select Installment</option>
                            @foreach (App\Models\LoanInstallment::with('loan')->where('status', 'pending')->get() as $inst)
                                <option value="{{ $inst->id }}">Loan #{{ $inst->loan->id ?? 'N/A' }} - Installment
                                    {{ $inst->installment_no }} - Due {{ $inst->due_date }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount Field -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            <iconify-icon icon="heroicons-outline:currency-dollar"
                                class="inline mr-2 text-slate-500"></iconify-icon>
                            Amount
                        </label>
                        <input type="number" name="amount" step="0.01" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00" />
                    </div>

                    <!-- Remarks Field -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            <iconify-icon icon="heroicons-outline:annotation"
                                class="inline mr-2 text-slate-500"></iconify-icon>
                            Remarks
                        </label>
                        <input name="remarks"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Optional remarks" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('loan_collections.index') }}"
                        class="px-4 py-2 text-slate-600 hover:text-slate-800 font-medium rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <iconify-icon icon="heroicons-outline:check" class="text-lg"></iconify-icon>
                        Create Collection
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
