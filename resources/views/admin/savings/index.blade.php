@extends('admin.partials.index')
@section('content')
    <div class="container">
        <h4 class="text-2xl font-bold text-gray-800 mb-4">Savings Dashboard</h4>

        <!-- Pending Deposits -->
        <h5 class="text-xl font-semibold text-blue-600 mb-3 border-b-2 border-blue-200 pb-1">
            Pending Deposits
        </h5>
        <table id="pending-deposits-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <!-- Deposit Form -->
        <h5>Deposit Savings</h5>
        <form method="POST" action="{{ route('savings.store') }}">
            @csrf
            <select id="member-select" name="member_id" class="form-control mb-2">
                @foreach (App\Models\Member::all() as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
            <input type="number" name="amount" class="form-control mb-2" placeholder="Amount">
            <button class="btn btn-primary">Submit Deposit</button>
        </form>

        <!-- Post Interest -->
        <form method="POST" action="{{ route('savings.postInterest') }}" class="mt-3">
            @csrf
            <button class="btn btn-warning">Post Monthly Interest</button>
        </form>

        <!-- Withdrawal Requests -->
        <!--  <h5>Withdrawal Requests</h5>
                <p><a href="{{ route('savings.withdrawals') }}" class="btn btn-info">View All Withdrawal Requests</a></p>
                <p>Pending Requests: {{ App\Models\SavingsWithdrawalRequest::where('status', 'pending')->count() }}</p>
            </div>-->

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
                    ]
                });

                // Initialize Select2 for searchable dropdown
                $('#member-select').select2({
                    placeholder: 'Select a member',
                    allowClear: true
                });
            });
        </script>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @endpush
    @endsection
