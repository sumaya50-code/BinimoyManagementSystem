@extends('admin.partials.index')
@section('content')
      <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('savings.index') }}" class="flex items-center text-primary-500">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Savings
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span> Withdrawal</span>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                           Savings Withdrawal Requests
                        </h1>
                        <p class="text-muted mb-0">Manage and process savings withdrawal requests</p>
                    </div>
                    <div>
                        <a href="{{ route('savings.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Requests
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $requests->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $requests->where('status', 'pending')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Approved
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $requests->where('status', 'approved')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Withdrawal Requests Table -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-table me-1"></i>Withdrawal Requests
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="withdrawals-table" class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-user me-1"></i>Member</th>
                                        <th><i class="fas fa-dollar-sign me-1"></i>Amount</th>
                                        <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                        <th><i class="fas fa-calendar me-1"></i>Date Requested</th>
                                        <th><i class="fas fa-cogs me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($requests as $request)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-initial rounded-circle bg-primary text-white">
                                                            {{ strtoupper(substr($request->member->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold">{{ $request->member->name }}</div>
                                                        <small class="text-muted">ID: {{ $request->member->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="fw-bold text-danger">${{ number_format($request->amount, 2) }}</span>
                                            </td>
                                            <td>
                                                @if ($request->status == 'pending')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>{{ ucfirst($request->status) }}
                                                    </span>
                                                @elseif($request->status == 'approved')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>{{ ucfirst($request->status) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times me-1"></i>{{ ucfirst($request->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        {{ $request->created_at->format('M d, Y') }}</div>
                                                    <small
                                                        class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if ($request->status == 'pending')
                                                        <a href="{{ route('savings.approveWithdrawal', $request->id) }}"
                                                            class="btn btn-success btn-sm" title="Approve Withdrawal">
                                                            <i class="fas fa-check"></i> Approve
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('savings.voucher', $request->id) }}"
                                                        class="btn btn-outline-info btn-sm" title="View Voucher">
                                                        <i class="fas fa-file-invoice"></i> Voucher
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Withdrawal Requests Found</h5>
                                                <p class="text-muted">There are currently no withdrawal requests to display.
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Withdrawal Request Form -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-plus-circle me-1"></i>New Withdrawal Request
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('savings.withdrawRequest') }}" id="withdrawal-form">
                            @csrf

                            <!-- Member Selection -->
                            <div class="mb-3">
                                <label for="member_id" class="form-label fw-bold">
                                    <i class="fas fa-user text-primary me-1"></i>Select Member
                                </label>
                                <select name="member_id" id="member_id"
                                    class="form-select @error('member_id') is-invalid @enderror" required>
                                    <option value="">Choose a member...</option>
                                    @foreach (App\Models\Member::all() as $member)
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
                            </div>

                            <!-- Amount -->
                            <div class="mb-3">
                                <label for="amount" class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign text-danger me-1"></i>Withdrawal Amount
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="amount" id="amount"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        value="{{ old('amount') }}" step="0.01" min="0.01"
                                        placeholder="Enter amount" required>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="fas fa-hand-holding-usd me-1"></i>Request Withdrawal
                                </button>
                            </div>
                        </form>

                        <!-- Help Text -->
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Withdrawal requests require approval before processing.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#withdrawals-table').DataTable({
                responsive: true,
                pageLength: 25,
                language: {
                    search: "Search requests:",
                    lengthMenu: "Show _MENU_ requests per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ requests",
                    emptyTable: "No withdrawal requests available"
                },
                columnDefs: [{
                    orderable: false,
                    targets: 4
                }],
                order: [
                    [3, 'desc']
                ] // Sort by date requested descending
            });

            // Initialize Select2 for member selection
            $('#member_id').select2({
                placeholder: 'Search and select a member...',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endsection
