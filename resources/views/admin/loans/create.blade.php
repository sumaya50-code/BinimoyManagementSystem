@extends('admin.partials.index')

@section('content')
    <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('loans.index') }}" class="flex items-center text-primary-500">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Loans
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>Create Loan</span>
            </nav>
        </div>
    </div>

    <div class="card shadow-md rounded-xl p-6">
        <form id="loanCreateForm"
            action="{{ isset($proposal) && $proposal ? route('loans.disburse', $proposal->id) : route('loans.store') }}"
            method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="font-medium">Member</label>
                <select name="member_id" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Select Member</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}"
                            {{ isset($proposal) && $proposal && $proposal->member_id == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Loan Amount</label>
                    <input type="number" name="loan_amount"
                        value="{{ isset($proposal) && $proposal ? $proposal->proposed_amount : '' }}"
                        class="w-full border px-3 py-2 rounded" required min="1" step="0.01">
                </div>
                <div>
                    <label class="font-medium">Interest Rate (%)</label>
                    <input type="number" name="interest_rate" class="w-full border px-3 py-2 rounded" required
                        step="0.01" min="0">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Installment Count</label>
                    <input type="number" name="installment_count" class="w-full border px-3 py-2 rounded" required
                        min="1">
                </div>

                <div>
                    <label class="font-medium">Installment Type</label>
                    <select name="installment_type" class="w-full border px-3 py-2 rounded">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="font-medium">Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded">
                    <option>Pending</option>
                    <option>Approved</option>
                    <option>Active</option>
                    <option>Completed</option>
                    <option>Overdue</option>
                </select>
            </div>

            <button class="bg-primary-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('loanCreateForm').addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        this.reportValidity();
                    }
                });
            });
        </script>
    @endpush
@endsection
