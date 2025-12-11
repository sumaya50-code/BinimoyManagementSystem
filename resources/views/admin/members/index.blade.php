@extends('admin.index')

@section('content')
    <!-- Page Header / Breadcrumb -->
      <div class="mb-6 flex justify-between items-center">

        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('members.index') }}" class="text-primary-500 hover:text-primary-600 flex items-center">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Members
            </a>

            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>

            <span class="text-slate-600 dark:text-slate-300">Members Management</span>
        </nav>

        <!-- Back Button -->
        <a href="{{ route('members.create') }}" class="btn btn-secondary flex items-center">
            <iconify-icon icon="heroicons-outline:plus" class="mr-1"></iconify-icon>
            Create Member
        </a>
    </div>

    <!-- Main Card -->
    <div class="card shadow-md rounded-xl">
        <div class="card-body p-4">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" id="memberTable">
                <thead class="bg-slate-100 dark:bg-slate-800">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">#</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Name</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">NID</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Phone</th>
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

    <!-- DataTables CDN -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script>
        $(function() {

            $('#memberTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('members.data') }}",

                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'nid', name: 'nid' },
                    { data: 'phone', name: 'phone' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ]
            });

        });
    </script>
@endpush
