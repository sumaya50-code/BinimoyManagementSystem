@extends('admin.index')

@section('content')
    <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('loans.index') }}" class="flex items-center text-primary-500">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Loans
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>Edit Loan</span>
            </nav>
        </div>
    </div>

    <div class="card shadow-md rounded-xl p-6">
        <form id="loanEditForm" action="{{ route('loans.update', $loan->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="font-medium">Member</label>
                <select name="member_id" class="w-full border px-3 py-2 rounded">
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}"
                            {{ $member->id == $loan->member_id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Loan Amount</label>
                    <input type="number" name="loan_amount" value="{{ $loan->loan_amount }}" class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="font-medium">Interest Rate</label>
                    <input type="number" name="interest_rate" value="{{ $loan->interest_rate }}" class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Installment Count</label>
                    <input type="number" name="installment_count" value="{{ $loan->installment_count }}" class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="font-medium">Installment Type</label>
                    <select name="installment_type" class="w-full border px-3 py-2 rounded">
                        <option value="daily" {{ $loan->installment_type == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ $loan->installment_type == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ $loan->installment_type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="font-medium">Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded">
                    @foreach (['Pending','Approved','Active','Completed','Overdue'] as $status)
                        <option value="{{ $status }}" {{ $loan->status == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-primary-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.getElementById('loanEditForm').addEventListener('submit', function(e){
            if (!this.checkValidity()) {
                e.preventDefault();
                this.reportValidity();
            }
        });
    });
</script>
@endpush

@endsection
