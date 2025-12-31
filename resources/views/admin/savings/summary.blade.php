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
                <span> Accounts Summary</span>
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
                            Savings Accounts Summary
                        </h1>
                        <p class="text-muted mb-0">Overview of all savings accounts and their balances</p>
                    </div>
                    <div>
                        <a href="{{ route('savings.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row mb-4">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Accounts
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $accounts->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Balance
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ${{ number_format($accounts->sum('balance'), 2) }}
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

        <!-- Accounts Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-table me-1"></i>Savings Accounts
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="summary-table" class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-user me-1"></i>Member</th>
                                        <th><i class="fas fa-id-card me-1"></i>Account No</th>
                                        <th><i class="fas fa-dollar-sign me-1"></i>Balance</th>
                                        <th><i class="fas fa-cogs me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($accounts as $account)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-3">
                                                        <span class="avatar-initial rounded-circle bg-primary text-white">
                                                            {{ strtoupper(substr($account->member->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold">{{ $account->member->name }}</div>
                                                        <small class="text-muted">Member ID:
                                                            {{ $account->member->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $account->account_no }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="fw-bold text-success">${{ number_format($account->balance, 2) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('savings.statement', $account->member_id) }}"
                                                    class="btn btn-secondary btn-sm">Statement</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Savings Accounts Found</h5>
                                                <p class="text-muted">There are currently no savings accounts to display.
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
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#summary-table').DataTable({
                responsive: true,
                pageLength: 25,
                language: {
                    search: "Search accounts:",
                    lengthMenu: "Show _MENU_ accounts per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ accounts",
                    emptyTable: "No savings accounts available"
                },
                columnDefs: [{
                    orderable: false,
                    targets: 3
                }]
            });
        });
    </script>
@endsection
