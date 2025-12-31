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
                <span>Account Details</span>
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
                            <i class="fas fa-eye text-primary me-2"></i>Savings Account Details
                        </h1>
                        <p class="text-muted mb-0">Detailed view of savings account information and transaction history</p>
                    </div>
                    <div>
                        <a href="{{ route('savings.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Overview Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Account Number
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $account->account_no }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-id-card fa-2x text-gray-300"></i>
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
                                    Current Balance
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ${{ number_format($account->balance, 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                    Interest Rate
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $account->interest_rate }}%
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percentage fa-2x text-gray-300"></i>
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
                                    Total Transactions
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $account->transactions->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Account Information -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user-circle me-1"></i>Account Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-lg me-3">
                                <span class="avatar-initial rounded-circle bg-primary text-white"
                                    style="width: 60px; height: 60px; font-size: 24px; display: flex; align-items: center; justify-content: center;">
                                    {{ strtoupper(substr($account->member->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $account->member->name }}</h5>
                                <small class="text-muted">Member ID: {{ $account->member->id }}</small>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-2">
                            <strong><i class="fas fa-calendar-plus text-muted me-2"></i>Created:</strong>
                            <span class="text-muted">{{ $account->created_at->format('M d, Y \a\t H:i') }}</span>
                        </div>

                        <div class="mb-2">
                            <strong><i class="fas fa-clock text-muted me-2"></i>Last Updated:</strong>
                            <span class="text-muted">{{ $account->updated_at->format('M d, Y \a\t H:i') }}</span>
                        </div>

                        <hr>

                        <!-- Quick Actions -->
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-bolt text-warning me-1"></i>Quick Actions
                        </h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('savings.statement', $account->member_id) }}" class="btn btn-outline-info">
                                <i class="fas fa-file-alt me-1"></i>View Statement
                            </a>
                            <a href="{{ route('savings.summary') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-1"></i>All Accounts
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-history me-1"></i>Transaction History
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="transactions-table" class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-calendar me-1"></i>Date</th>
                                        <th><i class="fas fa-tag me-1"></i>Type</th>
                                        <th><i class="fas fa-dollar-sign me-1"></i>Amount</th>
                                        <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                        <th><i class="fas fa-comment me-1"></i>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($account->transactions->sortByDesc('transaction_date') as $transaction)
                                        <tr>
                                            <td>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        {{ $transaction->transaction_date->format('M d, Y') }}</div>
                                                    <small
                                                        class="text-muted">{{ $transaction->transaction_date->format('H:i') }}</small>
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
                                                <span
                                                    class="text-muted">{{ $transaction->remarks ?: 'No remarks' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Transactions Found</h5>
                                                <p class="text-muted">This account has no transaction history yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#transactions-table').DataTable({
                responsive: true,
                pageLength: 10,
                ordering: false,
                language: {
                    search: "Search transactions:",
                    lengthMenu: "Show _MENU_ transactions per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ transactions",
                    emptyTable: "No transactions available"
                }
            });
        });
    </script>
@endsection
