@extends('admin.partials.index')

@section('content')
    <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('loan_proposals.index') }}" class="flex items-center text-primary-500">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Loan Proposals
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>Proposal Details</span>
            </nav>
            <div class="flex gap-2">
                @if ($loanProposal->status === 'pending')
                    <a href="{{ route('loan_proposals.edit', $loanProposal) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('loan_proposals.destroy', $loanProposal) }}" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this proposal?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                @endif
                <a href="{{ route('loan_proposals.pdf', $loanProposal) }}" class="btn btn-info btn-sm"
                    target="_blank">Download PDF</a>
                <a href="{{ route('loan_proposals.guarantor_pdf', $loanProposal) }}" class="btn btn-secondary btn-sm"
                    target="_blank">Guarantor Form</a>
            </div>
        </div>
    </div>

    <div class="card shadow-md rounded-xl p-6 space-y-6">
        <!-- Status Badge -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">Loan Proposal #{{ $loanProposal->id }}</h2>
            <span
                class="px-3 py-1 rounded-full text-sm font-medium
                @if ($loanProposal->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($loanProposal->status === 'under_audit') bg-blue-100 text-blue-800
                @elseif($loanProposal->status === 'manager_review') bg-purple-100 text-purple-800
                @elseif($loanProposal->status === 'area_manager_approval') bg-indigo-100 text-indigo-800
                @elseif($loanProposal->status === 'approved') bg-green-100 text-green-800
                @else bg-red-100 text-red-800 @endif">
                {{ ucfirst(str_replace('_', ' ', $loanProposal->status)) }}
            </span>
        </div>

        <!-- Member Information Section -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Member Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Member No.</label>
                    <p class="mt-1">{{ $loanProposal->member->member_no ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="font-medium">Member Name</label>
                    <p class="mt-1">{{ $loanProposal->member->name ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="font-medium">Mobile No.</label>
                    <p class="mt-1">{{ $loanProposal->member->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="font-medium">Admission Date</label>
                    <p class="mt-1">
                        {{ $loanProposal->member->created_at ? \Carbon\Carbon::parse($loanProposal->member->created_at)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="font-medium">Guardian's Name</label>
                    <p class="mt-1">{{ $loanProposal->member->guardian_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="font-medium">Present Address</label>
                    <p class="mt-1">{{ $loanProposal->member->present_address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Loan Proposal Details -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Loan Proposal Details</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Loan Proposal Date</label>
                    <p class="mt-1">
                        {{ $loanProposal->loan_proposal_date ? \Carbon\Carbon::parse($loanProposal->loan_proposal_date)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="font-medium">Type of Business</label>
                    <p class="mt-1">{{ $loanProposal->business_type ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Current Status -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Current Status</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Savings Balance</label>
                    <p class="mt-1">{{ number_format($loanProposal->savings_balance ?? 0, 2) }}</p>
                </div>
                <div>
                    <label class="font-medium">DPS Balance</label>
                    <p class="mt-1">{{ number_format($loanProposal->dps_balance ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Previous Loan Information -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Previous Loan Information</h3>
            @if ($loanProposal->previousLoans && $loanProposal->previousLoans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Installment No.</th>
                                <th class="px-4 py-2 text-left">Loan Amount</th>
                                <th class="px-4 py-2 text-left">Disbursement Date</th>
                                <th class="px-4 py-2 text-left">Repayment Date</th>
                                <th class="px-4 py-2 text-left">Probable Repayment Date</th>
                                <th class="px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanProposal->previousLoans as $prevLoan)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $prevLoan->installment_no ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        {{ $prevLoan->loan_amount ? number_format($prevLoan->loan_amount, 2) : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $prevLoan->disbursement_date ? \Carbon\Carbon::parse($prevLoan->disbursement_date)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $prevLoan->repayment_date ? \Carbon\Carbon::parse($prevLoan->repayment_date)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $prevLoan->probable_repayment_date ? \Carbon\Carbon::parse($prevLoan->probable_repayment_date)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="px-2 py-1 rounded text-sm
                                            @if ($prevLoan->loan_status === 'active') bg-green-100 text-green-800
                                            @elseif($prevLoan->loan_status === 'completed') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($prevLoan->loan_status ?? 'N/A') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No previous loans recorded.</p>
            @endif
        </div>

        <!-- Proposed Loan Amount -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Proposed Loan Amount</h3>
            <div>
                <label class="font-medium">Amount</label>
                <p class="mt-1 text-lg font-semibold">{{ number_format($loanProposal->proposed_amount, 2) }}</p>
            </div>
        </div>

        <!-- Guarantors -->
        <div class="border-t pt-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Guarantors</h3>
                @if ($loanProposal->status === 'pending')
                    <a href="{{ route('loan_guarantors.create', ['loan_proposal_id' => $loanProposal->id]) }}"
                        class="btn btn-primary btn-sm">
                        <iconify-icon icon="heroicons-outline:plus" class="w-4 h-4 mr-1"></iconify-icon>
                        Add Guarantor
                    </a>
                @endif
            </div>
            @if ($loanProposal->guarantors && $loanProposal->guarantors->count() > 0)
                <div class="space-y-4">
                    @foreach ($loanProposal->guarantors as $guarantor)
                        <div class="border rounded p-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="font-medium">Guarantor Name</label>
                                    <p class="mt-1">{{ $guarantor->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Father’s Name</label>
                                    <p class="mt-1">{{ $guarantor->father_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Relationship with Applicant</label>
                                    <p class="mt-1">{{ $guarantor->relationship ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Mobile No</label>
                                    <p class="mt-1">{{ $guarantor->mobile_no ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">NID Number</label>
                                    <p class="mt-1">{{ $guarantor->nid_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Present Address</label>
                                    <p class="mt-1">{{ $guarantor->present_address ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Guarantor Signature</label>
                                    <p class="mt-1">{{ $guarantor->guarantor_signature ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Thumb Impression</label>
                                    <p class="mt-1">{{ $guarantor->tip_sign ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Profession</label>
                                    <p class="mt-1">{{ $guarantor->profession ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Nationality</label>
                                    <p class="mt-1">{{ $guarantor->nationality ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Liabilities</label>
                                    <p class="mt-1">{{ $guarantor->liabilities ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium">Assets</label>
                                    <p class="mt-1">{{ $guarantor->assets ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No guarantors added yet.</p>
            @endif
        </div>

        <!-- Signatures -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Signatures</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Applicant's Signature</label>
                    <p class="mt-1">{{ $loanProposal->applicant_signature ?? 'Not signed' }}</p>
                </div>
                <div>
                    <label class="font-medium">Employee's Signature</label>
                    <p class="mt-1">{{ $loanProposal->employee_signature ?? 'Not signed' }}</p>
                </div>
            </div>
        </div>

        <!-- Audit Verification -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Audit Verification</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Audited & Verified</label>
                    <p class="mt-1">{{ $loanProposal->audited_verified ?? 'Not audited' }}</p>
                </div>
                <div>
                    <label class="font-medium">Recommended amount (thousand taka)</label>
                    <p class="mt-1">
                        {{ $loanProposal->approved_amount_audit ? number_format($loanProposal->approved_amount_audit, 3) : 'N/A' }}
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <label class="font-medium">Auditor's Signature</label>
                <p class="mt-1">{{ $loanProposal->auditor_signature ?? 'Not signed' }}</p>
            </div>
        </div>

        <!-- Manager Verification -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Manager Verification</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Verified by Manager</label>
                    <p class="mt-1">{{ $loanProposal->verified_by_manager ?? 'Not verified' }}</p>
                </div>
                <div>
                    <label class="font-medium">Recommended amount (thousand taka)</label>
                    <p class="mt-1">
                        {{ $loanProposal->approved_amount_manager ? number_format($loanProposal->approved_amount_manager, 3) : 'N/A' }}
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <label class="font-medium">Manager's Signature</label>
                <p class="mt-1">{{ $loanProposal->manager_signature ?? 'Not signed' }}</p>
            </div>
        </div>

        <!-- Area Manager Approval -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">Area Manager Approval</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Verified/Selected by Area Manager</label>
                    <p class="mt-1">{{ $loanProposal->verified_by_area_manager ?? 'Not verified' }}</p>
                </div>
                <div>
                    <label class="font-medium">Approved amount (thousand taka)</label>
                    <p class="mt-1">
                        {{ $loanProposal->approved_amount_area ? number_format($loanProposal->approved_amount_area, 3) : 'N/A' }}
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="font-medium">Date Approved</label>
                    <p class="mt-1">
                        {{ $loanProposal->date_approved ? \Carbon\Carbon::parse($loanProposal->date_approved)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="font-medium">Authorized Signatory's Signature</label>
                    <p class="mt-1">{{ $loanProposal->authorized_signatory_signature ?? 'Not signed' }}</p>
                </div>
            </div>
        </div>

        <!-- Workflow Actions -->
        @if ($loanProposal->status === 'pending')
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Actions</h3>
                <form action="{{ route('loan_proposals.submit_audit', $loanProposal) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">Submit for Audit</button>
                </form>
            </div>
        @elseif($loanProposal->status === 'under_audit')
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Audit Actions</h3>
                <div class="flex gap-2">
                    <form action="{{ route('loan_proposals.approve_audit', $loanProposal) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">Approve Audit</button>
                    </form>
                    <form action="{{ route('loan_proposals.reject_audit', $loanProposal) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <div class="flex gap-2">
                            <input type="text" name="reason" placeholder="Rejection reason"
                                class="border px-2 py-1 rounded" required>
                            <button type="submit" class="btn btn-danger">Reject Audit</button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($loanProposal->status === 'manager_review')
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Manager Review Actions</h3>
                <div class="flex gap-2">
                    <form action="{{ route('loan_proposals.approve_manager', $loanProposal) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">Approve Manager Review</button>
                    </form>
                    <form action="{{ route('loan_proposals.reject_manager', $loanProposal) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <div class="flex gap-2">
                            <input type="text" name="reason" placeholder="Rejection reason"
                                class="border px-2 py-1 rounded" required>
                            <button type="submit" class="btn btn-danger">Reject Manager Review</button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($loanProposal->status === 'area_manager_approval')
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Area Manager Approval Actions</h3>
                <div class="flex gap-2">
                    <form action="{{ route('loan_proposals.approve_area', $loanProposal) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <div class="flex gap-2 items-center">
                            <input type="number" name="disbursed_amount" placeholder="Disbursed amount"
                                class="border px-2 py-1 rounded" step="0.01" required>
                            <input type="number" name="installment_count" placeholder="Installments"
                                class="border px-2 py-1 rounded" required>
                            <select name="installment_type" class="border px-2 py-1 rounded" required>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                            <input type="number" name="interest_rate" placeholder="Interest %"
                                class="border px-2 py-1 rounded" step="0.01">
                            <button type="submit" class="btn btn-success">Approve & Disburse</button>
                        </div>
                    </form>
                    <form action="{{ route('loan_proposals.reject_area', $loanProposal) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <div class="flex gap-2">
                            <input type="text" name="reason" placeholder="Rejection reason"
                                class="border px-2 py-1 rounded" required>
                            <button type="submit" class="btn btn-danger">Reject Area Manager</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Associated Loan -->
        @if ($loanProposal->loan)
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Associated Loan</h3>
                <div class="bg-green-50 border border-green-200 rounded p-4">
                    <p><strong>Loan ID:</strong> {{ $loanProposal->loan->id }}</p>
                    <p><strong>Loan Amount:</strong> {{ number_format($loanProposal->loan->loan_amount, 2) }}</p>
                    <p><strong>Disbursed Amount:</strong> {{ number_format($loanProposal->loan->disbursed_amount, 2) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($loanProposal->loan->status) }}</p>
                    <a href="{{ route('loans.show', $loanProposal->loan) }}" class="btn btn-primary btn-sm mt-2">View
                        Loan Details</a>
                </div>
            </div>
        @endif
    </div>
@endsection
