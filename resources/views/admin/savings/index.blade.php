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
                <span>Dashboard</span>
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
                            Savings Dashboard
                        </h1>
                        <p class="text-muted mb-0">Manage savings accounts, deposits, and transactions</p>
                    </div>
                    <div>

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
                                    Total Accounts
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ App\Models\SavingsAccount::count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                    Total Balance
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ${{ number_format(App\Models\SavingsAccount::sum('balance'), 2) }}
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
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Deposits
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ App\Models\SavingsTransaction::where('status', 'pending')->count() }}
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
                                    Pending Withdrawals
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ App\Models\SavingsWithdrawalRequest::where('status', 'pending')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Pending Deposits -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-clock me-1"></i>Pending Deposits
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pending-deposits-table" class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Member</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-bolt me-1"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Deposit Form -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-plus-circle text-success me-1"></i>Deposit Savings
                            </h6>
                            <form method="POST" action="{{ route('savings.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <select id="member-select" name="member_id" class="form-select" required>
                                        <option value="">Select Member</option>
                                        @foreach (App\Models\Member::all() as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="number" name="amount" class="form-control" placeholder="Amount"
                                        step="0.01" min="0" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-save me-1"></i>Submit Deposit
                                </button>
                            </form>
                        </div>

                        <hr>

                        <!-- Post Interest -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-percentage text-warning me-1"></i>Monthly Interest
                            </h6>
                            <form method="POST" action="{{ route('savings.postInterest') }}">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-calculator me-1"></i>Post Monthly Interest
                                </button>
                            </form>
                        </div>

                        <!-- Withdrawal Requests Link -->
                        <div>
                            <a href="{{ route('savings.withdrawals') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-hand-holding-usd me-1"></i>View Withdrawal Requests
                                <span
                                    class="badge bg-info ms-1">{{ App\Models\SavingsWithdrawalRequest::where('status', 'pending')->count() }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#pending-deposits-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('savings.pendingDepositsData') }}',
                columns: [{
                        data: 'member_name',
                        name: 'member_name'
                    },
                    {
                        data: 'amount_formatted',
                        name: 'amount_formatted'
                    },
                    {
                        data: 'transaction_date_formatted',
                        name: 'transaction_date_formatted'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Search deposits:",
                    lengthMenu: "Show _MENU_ deposits per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ deposits"
                }
            });

            // Initialize Select2 for searchable dropdown
            $('#member-select').select2({
                placeholder: 'Select a member',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endsection
