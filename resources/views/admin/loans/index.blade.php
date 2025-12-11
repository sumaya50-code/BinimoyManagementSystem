@extends('admin.index')

@section('content')
    <!-- Page Header / Breadcrumb -->
    <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">

            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('loans.index') }}"
                    class="flex items-center text-primary-500 hover:text-primary-600 transition">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Loans
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>Loan List</span>
            </nav>

            <!-- Add New Loan Button -->
            <a href="{{ route('loans.create') }}"
                class="btn btn-secondary flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <iconify-icon icon="heroicons-outline:plus" class="w-4 h-4"></iconify-icon>
                Add New Loan
            </a>

        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-md rounded-xl">
        <div class="card-body p-4">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" id="loanTable">
                <thead class="bg-slate-100 dark:bg-slate-800">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">#</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Member</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Amount</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Interest</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Installment</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold">Loan Details</th>
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
            let table = $('#loanTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('loans.data') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'member_name', name: 'member_name' },
                    { data: 'loan_amount', name: 'loan_amount' },
                    { data: 'interest_rate', name: 'interest_rate' },
                    { data: 'installment_type', name: 'installment_type' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'loan_details', name: 'loan_details', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[1, 'desc']]
            });

            // DELETE ACTION
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                let url = $(this).data('url');

                if (confirm("Are you sure you want to delete this loan?")) {
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
