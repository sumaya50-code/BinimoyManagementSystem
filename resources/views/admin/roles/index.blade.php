@extends('admin.index')

@section('content')
<div class="mb-5 flex justify-between items-center">
    <ul class="m-0 p-0 list-none flex items-center space-x-2">
        <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
            <a href="{{ route('home') }}">
                <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                <iconify-icon icon="heroicons-outline:chevron-right"
                    class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
            </a>
        </li>
        <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
            Role Management
        </li>
    </ul>

    @can('role-create')
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <iconify-icon icon="heroicons-outline:plus" class="mr-1"></iconify-icon> Create New Role
        </a>
    @endcan
</div>

@if(session('success'))
    <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <header class="card-header noborder">
        <h4 class="card-title">Roles Table</h4>
    </header>
    <div class="card-body px-6 pb-6">
        <div class="overflow-x-auto -mx-6 dashcode-data-table">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                        <thead class="bg-slate-200 dark:bg-slate-700">
                            <tr>
                                <th scope="col" class="table-th">No</th>
                                <th scope="col" class="table-th">Name</th>
                                <th scope="col" class="table-th">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <td class="table-td">{{ $index + 1 }}</td>
                                    <td class="table-td">{{ $role->name }}</td>
                                    <td class="table-td">
                                        <div class="flex space-x-3 rtl:space-x-reverse">
                                            <!-- Edit -->
                                            @can('role-edit')
                                                <a href="{{ route('roles.edit', $role->id) }}" class="action-btn">
                                                    <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                </a>
                                            @endcan

                                            <!-- Delete -->
                                            @can('role-delete')
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn">
                                                        <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
