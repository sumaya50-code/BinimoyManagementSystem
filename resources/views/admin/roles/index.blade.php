@extends('admin.partials.index')

@section('content')
    <!-- Page Header / Breadcrumb -->
    <div class="mb-6 flex justify-between items-center">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-primary-500 hover:text-primary-600 flex items-center">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Home
            </a>

            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>

            <span class="text-slate-600 dark:text-slate-300">Role Management</span>
        </nav>

        <!-- Create Role Button -->
        @can('role-create')
            <a href="{{ route('roles.create') }}" class="btn btn-secondary flex items-center">
                <iconify-icon icon="heroicons-outline:plus" class="mr-1"></iconify-icon>
                Create New Role
            </a>
        @endcan
    </div>

    <!-- Success Alert -->
    @if (session('success'))
        <div class="alert alert-success mb-4 flex items-center gap-1">
            <iconify-icon icon="heroicons-outline:check-circle"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif


    <!-- Roles Table Card -->
    <div class="card shadow-md rounded-xl">
        <div class="card-body p-4">

            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" id="roleTable">
                <thead class="bg-slate-100 dark:bg-slate-800">
                    <tr>
                        <th class=" text-sm font-semibold">#</th>
                        <th class=" text-sm font-semibold">Role Name</th>
                        <th class="font-semibold">Permissions</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
@endsection


@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script>
        $(function() {
            $('#roleTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.data') }}",

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'permissions',
                        name: 'permissions',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
