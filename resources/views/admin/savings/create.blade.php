@extends('admin.partials.index')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-plus-circle text-primary me-2"></i>Create Savings Account
                        </h1>
                        <p class="text-muted mb-0">Create a new savings account for a member</p>
                    </div>
                    <div>
                        <a href="{{ route('savings.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user-plus me-1"></i>Account Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('savings.store') }}" id="create-account-form">
                            @csrf

                            <!-- Member Selection -->
                            <div class="mb-4">
                                <label for="member_id" class="form-label fw-bold">
                                    <i class="fas fa-user text-primary me-1"></i>Select Member
                                </label>
                                <select name="member_id" id="member_id"
                                    class="form-select form-select-lg @error('member_id') is-invalid @enderror"
                                    required>
                                    <option value="">Choose a member...</option>
                                    @foreach (\App\Models\Member::all() as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} (ID: {{ $member->id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle text-muted me-1"></i>
                                    Select the member who will own this savings account
                                </div>
                            </div>

                            <!-- Interest Rate -->
                            <div class="mb-4">
                                <label for="interest_rate" class="form-label fw-bold">
                                    <i class="fas fa-percentage text-success me-1"></i>Interest Rate (%)
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="number" name="interest_rate" id="interest_rate"
                                        class="form-control @error('interest_rate') is-invalid @enderror"
                                        value="{{ old('interest_rate', 5) }}" step="0.01" min="0" max="100"
                                        placeholder="Enter interest rate" required>
                                    <span class="input-group-text">
                                        <i class="fas fa-percent"></i>
                                    </span>
                                </div>
                                @error('interest_rate')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle text-muted me-1"></i>
                                    Annual interest rate for this savings account (default: 5%)
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div id="account-preview" class="alert alert-info" style="display: none;">
                                <h6 class="alert-heading">
                                    <i class="fas fa-eye me-1"></i>Account Preview
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Member:</strong> <span id="preview-member">-</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Interest Rate:</strong> <span id="preview-rate">-</span>%
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="{{ route('savings.index') }}" class="btn btn-outline-secondary me-md-2">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-1"></i>Create Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card shadow mt-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-question-circle me-1"></i>Help & Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">
                                    <i class="fas fa-user-check me-1"></i>Member Selection
                                </h6>
                                <p class="text-muted small">
                                    Choose the member who will own this savings account. Each member can have only one savings account.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-success">
                                    <i class="fas fa-percentage me-1"></i>Interest Rate
                                </h6>
                                <p class="text-muted small">
                                    Set the annual interest rate for this account. This rate will be used for monthly interest calculations.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for searchable dropdown
            $('#member_id').select2({
                placeholder: 'Search and select a member...',
                allowClear: true,
                width: '100%',
                theme: 'bootstrap-5'
            });

            // Update preview when form changes
            function updatePreview() {
                const memberSelect = $('#member_id');
                const rateInput = $('#interest_rate');
                const previewDiv = $('#account-preview');
                const previewMember = $('#preview-member');
                const previewRate = $('#preview-rate');

                const selectedMember = memberSelect.find('option:selected').text();
                const rateValue = rateInput.val();

                if (selectedMember && selectedMember !== 'Choose a member...' && rateValue) {
                    previewMember.text(selectedMember.replace(' (ID: ', ' - ID: ').replace(')', ''));
                    previewRate.text(rateValue);
                    previewDiv.show();
                } else {
                    previewDiv.hide();
                }
            }

            // Bind events
            $('#member_id, #interest_rate').on('change input', updatePreview);

            // Form validationyy
