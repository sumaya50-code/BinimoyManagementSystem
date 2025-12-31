@extends('admin.partials.index')

@section('content')
    <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('loan_guarantors.index') }}" class="flex items-center text-primary-500">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Loan Guarantors
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>{{ $loanGuarantor->name }}</span>
            </nav>
        </div>
    </div>

    <div class="card shadow-md rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4">Personal Guarantor Information</h3>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Name</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->name }}</p>
            </div>
            <div>
                <label class="font-medium">Mother’s Name</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->mother_name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Father’s Name</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->father_name }}</p>
            </div>
            <div>
                <label class="font-medium">Nationality</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->nationality }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Relationship with Applicant</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->relationship }}</p>
            </div>
            <div>
                <label class="font-medium">Mobile No.</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->mobile_no }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">E-mail</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->email }}</p>
            </div>
            <div>
                <label class="font-medium">Profession</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->profession }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">NID Number</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->nid_number }}</p>
            </div>
            <div>
                <label class="font-medium">Liabilities</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->liabilities }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Assets</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->assets }}</p>
            </div>
        </div>

        <h4 class="text-md font-semibold mt-6">Present Address</h4>
        <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->present_address }}</p>

        <h4 class="text-md font-semibold mt-6">Permanent Address</h4>
        <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->permanent_address }}</p>

        <h4 class="text-md font-semibold mt-6">Declaration</h4>
        <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->declaration }}</p>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Investment Received</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->investment_received }}</p>
            </div>
            <div>
                <label class="font-medium">Investment Amount (in words)</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->investment_amount_words }}</p>
            </div>
        </div>

        <h4 class="text-md font-semibold mt-6">Signatures</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Guarantor’s Signature</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->guarantor_signature }}</p>
            </div>
            <div>
                <label class="font-medium">Tip Sign (Thumb Impression)</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->tip_sign }}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Employee’s Signature</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->employee_signature }}</p>
            </div>
            <div>
                <label class="font-medium">Manager’s Signature</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->manager_signature }}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Authorized Person Name</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->authorized_person_name }}</p>
            </div>
            <div>
                <label class="font-medium">Authorized Person Signature</label>
                <p class="border px-3 py-2 rounded bg-gray-50">{{ $loanGuarantor->authorized_person_signature }}</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('loan_guarantors.edit', $loanGuarantor->id) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded mr-2">Edit</a>
            <a href="{{ route('loan_guarantors.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Back to
                List</a>
        </div>
    </div>
@endsection
