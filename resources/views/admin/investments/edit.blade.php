@extends('admin.partials.index')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('investments.index') }}" class="text-primary-500 hover:text-primary-600 flex items-center">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Investments
            </a>
            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
            <span class="text-slate-600 dark:text-slate-300">Edit Investment Application</span>
        </nav>
    </div>

    <div class="card shadow-md rounded-xl">
        <div class="card-header bg-slate-100 dark:bg-slate-800 px-6 py-4">
            <h4 class="card-title">Edit Investment Application</h4>
        </div>
        <div class="card-body p-6">
            <form action="{{ route('investments.update', $investment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="member_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Member
                            (Optional)</label>
                        <select name="member_id" id="member_id" class="form-control mt-1">
                            <option value="">Select Member</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ $investment->member_id == $member->id ? 'selected' : '' }}>{{ $member->name }}
                                    ({{ $member->member_no }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="partner_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Partner
                            (Optional)</label>
                        <select name="partner_id" id="partner_id" class="form-control mt-1">
                            <option value="">Select Partner</option>
                            @foreach ($partners as $partner)
                                <option value="{{ $partner->id }}"
                                    {{ $investment->partner_id == $partner->id ? 'selected' : '' }}>{{ $partner->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="applied_amount"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300">Applied Amount</label>
                        <input type="number" name="applied_amount" id="applied_amount" class="form-control mt-1"
                            step="0.01" value="{{ $investment->applied_amount }}" required>
                    </div>
                    <div>
                        <label for="business_name"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300">Business Name</label>
                        <input type="text" name="business_name" id="business_name" class="form-control mt-1"
                            value="{{ $investment->business_name }}" required>
                    </div>
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Owner
                            Name</label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control mt-1"
                            value="{{ $investment->owner_name }}" required>
                    </div>
                    <div>
                        <label for="trade_license_no"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300">Trade License No</label>
                        <input type="text" name="trade_license_no" id="trade_license_no" class="form-control mt-1"
                            value="{{ $investment->trade_license_no }}" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="business_address"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300">Business Address</label>
                        <textarea name="business_address" id="business_address" rows="3" class="form-control mt-1" required>{{ $investment->business_address }}</textarea>
                    </div>
                    <div>
                        <label for="business_type"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300">Business Type</label>
                        <input type="text" name="business_type" id="business_type" class="form-control mt-1"
                            value="{{ $investment->business_type }}" required>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('investments.show', $investment->id) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Application</button>
                </div>
            </form>
        </div>
    </div>
@endsection
