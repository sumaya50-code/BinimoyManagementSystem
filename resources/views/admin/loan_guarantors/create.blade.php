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
                <a href="{{ route('loan_proposals.show', $loanProposal) }}" class="flex items-center text-primary-500">
                    Proposal #{{ $loanProposal->id }}
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>Add Guarantor</span>
            </nav>
        </div>
    </div>

    <div class="card shadow-md rounded-xl p-6">
        <form action="{{ route('loan_guarantors.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="loan_proposal_id" value="{{ $loanProposal->id }}">

            <h3 class="text-lg font-semibold mb-4">Personal Guarantor Information Form</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter full name" required>
                </div>
                <div>
                    <label class="font-medium">Mother’s Name</label>
                    <input type="text" name="mother_name" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter mother's full name">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Father’s Name</label>
                    <input type="text" name="father_name" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter father's full name">
                </div>
                <div>
                    <label class="font-medium">Nationality</label>
                    <input type="text" name="nationality" class="w-full border px-3 py-2 rounded"
                        placeholder="e.g., Bangladeshi">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Relationship with Applicant</label>
                    <input type="text" name="relationship" class="w-full border px-3 py-2 rounded"
                        placeholder="e.g., Father, Brother, Friend">
                </div>
                <div>
                    <label class="font-medium">Mobile No.</label>
                    <input type="text" name="mobile_no" class="w-full border px-3 py-2 rounded"
                        placeholder="e.g., +880 1XX XXX XXXX">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">E-mail</label>
                    <input type="email" name="email" class="w-full border px-3 py-2 rounded"
                        placeholder="e.g., example@email.com">
                </div>
                <div>
                    <label class="font-medium">Profession</label>
                    <input type="text" name="profession" class="w-full border px-3 py-2 rounded"
                        placeholder="e.g., Businessman, Teacher, Engineer">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">NID Number <span class="text-red-500">*</span></label>
                    <input type="text" name="nid_number" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter National ID number" required>
                </div>
                <div>
                    <label class="font-medium">Liabilities</label>
                    <input type="text" name="liabilities" class="w-full border px-3 py-2 rounded"
                        placeholder="Describe any financial liabilities">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Assets</label>
                    <input type="text" name="assets" class="w-full border px-3 py-2 rounded"
                        placeholder="Describe assets owned">
                </div>
            </div>

            <h4 class="text-md font-semibold mt-6">Present Address</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Village/Area</label>
                    <input type="text" name="present_village" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter village or area name">
                </div>
                <div>
                    <label class="font-medium">Thana</label>
                    <input type="text" name="present_thana" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter thana name">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Upazila</label>
                    <input type="text" name="present_upazila" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter upazila name">
                </div>
                <div>
                    <label class="font-medium">District</label>
                    <input type="text" name="present_district" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter district name">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Post Code</label>
                    <input type="text" name="present_postcode" class="w-full border px-3 py-2 rounded"
                        placeholder="e.g., 1234">
                </div>
            </div>

            <h4 class="text-md font-semibold mt-6">Permanent Address</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Village/Area</label>
                    <input type="text" name="permanent_village" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter village or area name">
                </div>
                <div>
                    <label class="font-medium">Thana</label>
                    <input type="text" name="permanent_thana" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter thana name">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Upazila</label>
                    <input type="text" name="permanent_upazila" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter upazila name">
                </div>
                <div>
                    <label class="font-medium">District</label>
                    <input type="text" name="permanent_district" class="w-full border px-3 py-2 rounded"
                        placeholder="Enter district name">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Post Code</label>
                    <input type="text" name="permanent_postcode" class="w-full border px-3 py-2 rounded"
                        placeholder="e.g., 1234">
                </div>
            </div>

            <h4 class="text-md font-semibold mt-6">Declaration</h4>
            <div>
                <label class="font-medium">Declaration Text</label>
                <textarea name="declaration" class="w-full border px-3 py-2 rounded" rows="4"
                    placeholder="I hereby declare that I, [Name], take full responsibility for the investment/loan of [Applicant]. Investment Received: [Amount]. Investment Amount (in words): [Amount in words]. If the loan amount is not repaid, I shall be bound to repay the full amount. Otherwise, I will not raise any objection to any legal action taken by the society against me, except through lawful means."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Investment Received</label>
                    <input type="text" name="investment_received" class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="font-medium">Investment Amount (in words)</label>
                    <input type="text" name="investment_amount_words" class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <h4 class="text-md font-semibold mt-6">Signatures</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Guarantor’s Signature</label>
                    <input type="text" name="guarantor_signature" class="w-full border px-3 py-2 rounded"
                        placeholder="Signature or text">
                </div>
                <div>
                    <label class="font-medium">Tip Sign (Thumb Impression)</label>
                    <select name="tip_sign" class="w-full border px-3 py-2 rounded">
                        <option value="">Select</option>
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Employee’s Signature</label>
                    <input type="text" name="employee_signature" class="w-full border px-3 py-2 rounded"
                        placeholder="Signature or text">
                </div>
                <div>
                    <label class="font-medium">Manager’s Signature</label>
                    <input type="text" name="manager_signature" class="w-full border px-3 py-2 rounded"
                        placeholder="Signature or text">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Authorized Person Name</label>
                    <input type="text" name="authorized_person_name" class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="font-medium">Authorized Person Signature</label>
                    <input type="text" name="authorized_person_signature" class="w-full border px-3 py-2 rounded"
                        placeholder="Signature or text">
                </div>
            </div>

            <button class="bg-primary-600 text-white px-4 py-2 rounded">Add Guarantor</button>
        </form>
    </div>
@endsection
