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
                <span> Transactions</span>
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
                            <i class="fas fa-exchange-alt text-primary me-2"></i>Savings Transactions
                        </h1>
                        <p class="text-muted mb-0">View and manage all savings account transactions</p>
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
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Transactions
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $transactions->total() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Approved
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $transactions->where('status', 'approved')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $transactions->where('status', 'pending')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Amount
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ${{ number_format($transactions->sum('amount'), 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-table me-1"></i>All Transactions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="transactions-table" class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-id-card me-1"></i>Account No</th>
                                        <th><i class="fas fa-user me-1"></i>Member</th>
                                        <th><i class="fas fa-tag me-1"></i>Type</th>
                                        <th><i class="fas fa-dollar-sign me-1"></i>Amount</th>
                                        <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                        <th><i class="fas fa-calendar me-1"></i>Date</th>
                                        <th><i class="fas fa-comment me-1"></i>Remarks</th>
                                        <th><i class="fas fa-cogs me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <span
                                                    class="badge bg-light text-dark">{{ $transaction->account->account_no }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-initial rounded-circle bg-primary text-white">
                                                            {{ strtoupper(substr($transaction->account->member->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold">
                                                            {{ $transaction->account->member->name }}</div>
                                                        <small class="text-muted">ID:
                                                            {{ $transaction->account->member->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($transaction->type == 'deposit')
                                                    <span class="badge bg-success">
                                                        <i
                                                            class="fas fa-arrow-up me-1"></i>{{ ucfirst($transaction->type) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i
                                                            class="fas fa-arrow-down me-1"></i>{{ ucfirst($transaction->type) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="fw-bold {{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                                    {{ $transaction->type == 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($transaction->status == 'approved')
                                                    <span class="badge bg-success">
                                                        <i
                                                            class="fas fa-check me-1"></i>{{ ucfirst($transaction->status) }}
                                                    </span>
                                                @elseif($transaction->status == 'pending')
                                                    <span class="badge bg-warning">
                                                        <i
                                                            class="fas fa-clock me-1"></i>{{ ucfirst($transaction->status) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i
                                                            class="fas fa-times me-1"></i>{{ ucfirst($transaction->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        {{ $transaction->transaction_date->format('M d, Y') }}</div>
                                                    <small
                                                        class="text-muted">{{ $transaction->transaction_date->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $transaction->remarks ?: 'No remarks' }}</span>
                                            </td>
                                            <td>
                                                @if ($transaction->type == 'deposit' && $transaction->status == 'pending')
                                                    <a href="{{ route('savings.approveDeposit', $transaction->id) }}"
                                                        class="btn btn-success btn-sm" title="Approve Deposit">
                                                        <i class="fas fa-check"></i> Approve
                                                    </a>
                                                @else
                                                    <span class="text-muted small">
                                                        <i class="fas fa-check-circle me-1"></i>No action needed
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Transactions Found</h5>
                                                <p class="text-muted">There are currently no savings transactions to
                                                    display.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($transactions->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $transactions->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#transactions-table').DataTable({
                responsive: true,
                pageLength: 25,
                language: {
                    search: "Search transactions:",
                    lengthMenu: "Show _MENU_ transactions per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ transactions",
                    emptyTable: "No transactions available"
                },
                columnDefs: [{
                    orderable: false,
                    targets: 7
                }],
                order: [
                    [5, 'desc']
                ] // Sort by date descending
            });
        });
    </script>
@endsection
