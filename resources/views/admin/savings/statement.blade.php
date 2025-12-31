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
                <span> Savings Statement</span>
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
                            Savings Statement
                        </h1>
                        <p class="text-muted mb-0">Detailed transaction history for savings account</p>
                    </div>
                    <div>
                        <a href="{{ route('savings.index', $account->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Account
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Account Holder
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    {{ $account->member->name }}
                                </div>
                                <small class="text-muted">Member ID: {{ $account->member->id }}</small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Account Number
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
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
            <div class="col-xl-4 col-md-6 mb-4">
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
        </div>

        <!-- Transaction History -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-history me-1"></i>Transaction History
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="statement-table" class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-calendar me-1"></i>Date & Time</th>
                                        <th><i class="fas fa-tag me-1"></i>Type</th>
                                        <th><i class="fas fa-dollar-sign me-1"></i>Amount</th>
                                        <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                        <th><i class="fas fa-comment me-1"></i>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($account->transactions->sortByDesc('transaction_date') as $txn)
                                        <tr>
                                            <td>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        {{ \Carbon\Carbon::parse($txn->transaction_date)->format('M d, Y') }}
                                                    </div>
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($txn->transaction_date)->format('H:i:s') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($txn->type == 'deposit')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-arrow-up me-1"></i>{{ ucfirst($txn->type) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-arrow-down me-1"></i>{{ ucfirst($txn->type) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="fw-bold {{ $txn->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                                    {{ $txn->type == 'deposit' ? '+' : '-' }}${{ number_format($txn->amount, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($txn->status == 'approved')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>{{ ucfirst($txn->status) }}
                                                    </span>
                                                @elseif($txn->status == 'pending')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>{{ ucfirst($txn->status) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times me-1"></i>{{ ucfirst($txn->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $txn->remarks ?: 'No remarks' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Transactions Found</h5>
                                                <p class="text-muted">This account has no transaction history yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Footer -->
                        @if ($account->transactions->count() > 0)
                            <div class="row mt-4 pt-3 border-top">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">Total Deposits:</span>
                                        <span class="text-success fw-bold">
                                            ${{ number_format($account->transactions->where('type', 'deposit')->sum('amount'), 2) }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">Total Withdrawals:</span>
                                        <span class="text-danger fw-bold">
                                            ${{ number_format($account->transactions->where('type', 'withdrawal')->sum('amount'), 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">Total Transactions:</span>
                                        <span class="text-primary fw-bold">{{ $account->transactions->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">Current Balance:</span>
                                        <span
                                            class="text-success fw-bold h5">${{ number_format($account->balance, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#statement-table').DataTable({
                responsive: true,
                pageLength: 25,
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
