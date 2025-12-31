@extends('admin.partials.index')

@section('content')
    <!-- Page Header / Breadcrumb -->
    <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">

            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('loan_proposals.index') }}"
                    class="flex items-center text-primary-500 hover:text-primary-600 transition">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Loan Proposals
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>Proposal List</span>
            </nav>

            <!-- Add New Proposal Button -->
            <div class="flex items-center gap-3">
                <a href="{{ route('loan_proposals.create') }}"
                    class="btn btn-secondary flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <iconify-icon icon="heroicons-outline:plus" class="w-4 h-4"></iconify-icon>
                    Add New Proposal
                </a>

                <!-- Status Filter -->
                <select id="proposalStatusFilter" class="border px-3 py-2 rounded text-sm">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-md rounded-xl">
        <div class="card-body p-4">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" id="proposalTable">
                <thead class="bg-slate-100 dark:bg-slate-800">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">#</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Member</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Proposed Amount</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Business Type</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script>
        $(function() {
            let table = $('#proposalTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('loan_proposals.data') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'member_name', name: 'member_name' },
                    { data: 'proposed_amount', name: 'proposed_amount' },
                    { data: 'business_type', name: 'business_type' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[1, 'desc']]
            });

            // Status filter
            $('#proposalStatusFilter').on('change', function() {
                let v = $(this).val();
                if (v === '') {
                    table.column(4).search('').draw();
                } else {
                    table.column(4).search(v, true, false).draw();
                }
            });

            // DELETE ACTION
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                let url = $(this).data('url');

                if (confirm("Are you sure you want to delete this proposal?")) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(response) {
                            table.ajax.reload();
                            alert(response.message);
                        }
                    });
                }
            });
        });
    </script>
@endpush
