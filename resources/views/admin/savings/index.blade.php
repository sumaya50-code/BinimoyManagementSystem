@extends('admin.index')

@section('content')
    <!-- Page Header / Breadcrumb -->
    <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">

            <!-- Breadcrumb Left -->
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('savings.index') }}"
                    class="flex items-center text-primary-500 hover:text-primary-600 transition">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Savings
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>Edit Savings Transaction</span>
            </nav>

            <!-- Small Back Button Right -->
            <a href="{{ route('savings.create') }}"
                class="btn btn-secondary flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <iconify-icon icon="heroicons-outline:plus" class="w-4 h-4"></iconify-icon>
                Add New Transaction
            </a>


        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-md rounded-xl">
        <div class="card-body p-4">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" id="savingsTable">
                <thead class="bg-slate-100 dark:bg-slate-800">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">#</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Member</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Type</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Amount</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Balance</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Interest</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CDN -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script>
        $(function() {
            $('#savingsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('savings.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'member',
                        name: 'member'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'interest',
                        name: 'interest',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ]
            });
        });
    </script>
@endpush
