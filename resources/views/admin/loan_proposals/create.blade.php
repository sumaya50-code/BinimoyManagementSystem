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
                <span>Create Proposal</span>
            </nav>
        </div>
    </div>

    <div class="card shadow-md rounded-xl p-6">
        <form id="proposalCreateForm" action="{{ route('loan_proposals.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Member Selection -->
            <div>
                <label class="font-medium">Member <span class="text-red-500">*</span></label>
                <select name="member_id" id="member_select" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Select Member</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}" data-member='{{ json_encode($member) }}'>{{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Member Information Section -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Member Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Member Mobile No.</label>
                        <input type="text" id="member_phone" class="w-full border px-3 py-2 rounded bg-gray-100"
                            readonly>
                    </div>
                    <div>
                        <label class="font-medium">Admission Date</label>
                        <input type="text" id="admission_date" class="w-full border px-3 py-2 rounded bg-gray-100"
                            readonly>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="font-medium">Member No.</label>
                        <input type="text" id="member_no" class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
                    </div>
                    <div>
                        <label class="font-medium">Member Name</label>
                        <input type="text" id="member_name" class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="font-medium">Guardian's Name</label>
                        <input type="text" id="guardian_name" class="w-full border px-3 py-2 rounded bg-gray-100"
                            readonly>
                    </div>
                    <div>
                        <label class="font-medium">Present Address</label>
                        <textarea id="present_address" class="w-full border px-3 py-2 rounded bg-gray-100" rows="2" readonly></textarea>
                    </div>
                </div>
            </div>



            <!-- Loan Proposal Details -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Loan Proposal Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Loan Proposal Date <span class="text-red-500">*</span></label>
                        <input type="date" name="loan_proposal_date" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="font-medium">Type of Business <span class="text-red-500">*</span></label>
                        <input type="text" name="business_type" class="w-full border px-3 py-2 rounded" required
                            maxlength="255">
                    </div>
                </div>
            </div>

            <!-- Current Status -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Current Status</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Savings Balance</label>
                        <input type="number" id="savings_balance" name="savings_balance"
                            class="w-full border px-3 py-2 rounded bg-gray-100" step="0.01" readonly required>
                    </div>
                    <div>
                        <label class="font-medium">DPS Balance</label>
                        <input type="number" id="dps_balance" name="dps_balance"
                            class="w-full border px-3 py-2 rounded bg-gray-100" step="0.01" readonly>
                    </div>
                </div>
            </div>



            <!-- Previous Loan Information -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Previous Loan Information</h3>
                <div id="previous-loans-container">
                    <div class="previous-loan-entry border rounded p-4 mb-4">
                        <div class="grid grid-cols-6 gap-2 mb-2">
                            <div>
                                <label class="font-medium text-sm">Installment No.</label>
                                <input type="number" name="previous_loans[0][installment_no]"
                                    class="w-full border px-2 py-1 rounded text-sm" min="1">
                            </div>
                            <div>
                                <label class="font-medium text-sm">Loan Amount</label>
                                <input type="number" name="previous_loans[0][loan_amount]"
                                    class="w-full border px-2 py-1 rounded text-sm" step="0.01">
                            </div>
                            <div>
                                <label class="font-medium text-sm">Loan Disbursement Date</label>
                                <input type="date" name="previous_loans[0][disbursement_date]"
                                    class="w-full border px-2 py-1 rounded text-sm">
                            </div>
                            <div>
                                <label class="font-medium text-sm">Repayment Date</label>
                                <input type="date" name="previous_loans[0][repayment_date]"
                                    class="w-full border px-2 py-1 rounded text-sm">
                            </div>
                            <div>
                                <label class="font-medium text-sm">Probable Repayment Date</label>
                                <input type="date" name="previous_loans[0][probable_repayment_date]"
                                    class="w-full border px-2 py-1 rounded text-sm">
                            </div>
                            <div>
                                <label class="font-medium text-sm">Loan Status</label>
                                <select name="previous_loans[0][loan_status]"
                                    class="w-full border px-2 py-1 rounded text-sm">
                                    <option value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="completed">Completed</option>
                                    <option value="defaulted">Defaulted</option>
                                </select>
                            </div>
                        </div>
                        <button type="button"
                            class="remove-previous-loan bg-red-500 text-white px-2 py-1 rounded text-sm"
                            style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-previous-loan" class="bg-blue-500 text-white px-4 py-2 rounded">Add
                    Previous Loan</button>
            </div>

            <!-- Proposed Loan Amount -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Proposed Loan Amount</h3>
                <div>
                    <label class="font-medium">Amount <span class="text-red-500">*</span></label>
                    <input type="number" name="proposed_amount" class="w-full border px-3 py-2 rounded" required
                        min="1" step="0.01">
                </div>
            </div>

            <!-- Signatures -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Signatures</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Applicant's Signature</label>
                        <input type="text" name="applicant_signature" class="w-full border px-3 py-2 rounded"
                            placeholder="Signature">
                    </div>
                    <div>
                        <label class="font-medium">Employee's Signature</label>
                        <input type="text" name="employee_signature" class="w-full border px-3 py-2 rounded"
                            placeholder="Signature">
                    </div>
                </div>
            </div>

            <!-- Audit Verification -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Audit Verification</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Audited & Verified</label>
                        <input type="text" name="audited_verified" class="w-full border px-3 py-2 rounded"
                            placeholder="Auditor Name">
                    </div>
                    <div>
                        <label class="font-medium">Recommended amount (thousand taka)</label>
                        <input type="number" name="approved_amount_audit" class="w-full border px-3 py-2 rounded"
                            step="0.001">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="font-medium">Auditor's Signature</label>
                    <input type="text" name="auditor_signature" class="w-full border px-3 py-2 rounded"
                        placeholder="Signature">
                </div>
            </div>

            <!-- Manager Verification -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Manager Verification</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Verified by Manager</label>
                        <input type="text" name="verified_by_manager" class="w-full border px-3 py-2 rounded"
                            placeholder="Manager Name">
                    </div>
                    <div>
                        <label class="font-medium">Recommended amount (thousand taka)</label>
                        <input type="number" name="approved_amount_manager" class="w-full border px-3 py-2 rounded"
                            step="0.001">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="font-medium">Manager's Signature</label>
                    <input type="text" name="manager_signature" class="w-full border px-3 py-2 rounded"
                        placeholder="Signature">
                </div>
            </div>

            <!-- Area Manager Approval -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-4">Area Manager Approval</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Verified/Selected by Area Manager</label>
                        <input type="text" name="verified_by_area_manager" class="w-full border px-3 py-2 rounded"
                            placeholder="Area Manager Name">
                    </div>
                    <div>
                        <label class="font-medium">Approved amount (thousand taka)</label>
                        <input type="number" name="approved_amount_area" class="w-full border px-3 py-2 rounded"
                            step="0.001">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="font-medium">Date</label>
                        <input type="date" name="date_approved" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="font-medium">Authorized Signatory's Signature</label>
                        <input type="text" name="authorized_signatory_signature"
                            class="w-full border px-3 py-2 rounded" placeholder="Signature">
                    </div>
                </div>
            </div>

            <button class="bg-primary-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Function to handle member selection
                const handleMemberChange = function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const memberData = selectedOption.getAttribute('data-member');
                    const memberId = this.value;

                    console.log('Member select changed, memberId:', memberId, 'memberData:', memberData);

                    if (memberData) {
                        const member = JSON.parse(memberData);
                        document.getElementById('member_phone').value = member.phone || '';
                        document.getElementById('admission_date').value = member.created_at ? new Date(member
                            .created_at).toLocaleDateString() : '';
                        document.getElementById('member_no').value = member.member_no || '';
                        document.getElementById('member_name').value = member.name || '';
                        document.getElementById('guardian_name').value = member.guardian_name || '';
                        document.getElementById('present_address').value = member.present_address || '';

                        // Fetch savings balance
                        if (memberId) {
                            console.log('Fetching savings balance for member:', memberId);
                            fetch(`{{ route('loan_proposals.get_savings_balance') }}?member_id=${memberId}`, {
                                    credentials: 'same-origin'
                                })
                                .then(response => {
                                    console.log('Response status:', response.status);
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Received data:', data);
                                    console.log('Savings balance value:', data.savings_balance);
                                    console.log('Type of savings_balance:', typeof data.savings_balance);
                                    document.getElementById('savings_balance').value = parseFloat(data
                                        .savings_balance) || 0;
                                    // Set DPS balance to 0 as it's not implemented yet
                                    document.getElementById('dps_balance').value = 0;
                                })
                                .catch(error => {
                                    console.error('Error fetching savings balance:', error);
                                    document.getElementById('savings_balance').value = 0;
                                    document.getElementById('dps_balance').value = 0;
                                });
                        }
                    } else {
                        // Clear fields if no member selected
                        document.getElementById('member_phone').value = '';
                        document.getElementById('admission_date').value = '';
                        document.getElementById('member_no').value = '';
                        document.getElementById('member_name').value = '';
                        document.getElementById('guardian_name').value = '';
                        document.getElementById('present_address').value = '';
                        document.getElementById('savings_balance').value = '';
                    }
                };

                // Member selection auto-fill
                document.getElementById('member_select').addEventListener('change', handleMemberChange);

                // Trigger change event if a member is already selected on page load
                const memberSelect = document.getElementById('member_select');
                if (memberSelect.value) {
                    handleMemberChange.call(memberSelect);
                }

                document.getElementById('proposalCreateForm').addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        this.reportValidity();
                    }
                });

                // Add/Remove Previous Loan functionality
                let previousLoanIndex = 1;
                document.getElementById('add-previous-loan').addEventListener('click', function() {
                    const container = document.getElementById('previous-loans-container');
                    const newPreviousLoan = document.querySelector('.previous-loan-entry').cloneNode(true);

                    // Update input names
                    const inputs = newPreviousLoan.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const name = input.name.replace('[0]', '[' + previousLoanIndex + ']');
                        input.name = name;
                        input.value = '';
                    });

                    // Show remove button
                    newPreviousLoan.querySelector('.remove-previous-loan').style.display = 'inline-block';

                    container.appendChild(newPreviousLoan);
                    previousLoanIndex++;
                });

                // Event delegation for remove buttons
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-previous-loan')) {
                        e.target.closest('.previous-loan-entry').remove();
                    }
                });
            });
        </script>
    @endpush
@endsection
