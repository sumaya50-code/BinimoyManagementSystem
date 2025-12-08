@extends('admin.index')

@section('content')

<!-- Page Header / Breadcrumb -->
<div class="mb-6 flex justify-between items-center">
    <ul class="m-0 p-0 list-none flex items-center space-x-2">
        <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter">
            <a href="{{ route('home') }}">
                <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                <iconify-icon icon="heroicons-outline:chevron-right"
                    class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
            </a>
        </li>
        <li class="inline-block text-sm text-slate-500 font-Inter dark:text-white">
            Role Management
        </li>
    </ul>

    @can('role-create')
        <a href="{{ route('roles.create') }}" class="btn btn-primary flex items-center">
            <iconify-icon icon="heroicons-outline:plus" class="mr-1"></iconify-icon>
            Create New Role
        </a>
    @endcan
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success mb-4" role="alert">
        <iconify-icon icon="heroicons:check-circle" class="mr-1"></iconify-icon>
        {{ session('success') }}
    </div>
@endif

<!-- Main Card -->
<div class="card shadow-md rounded-xl">
    <header class="card-header noborder flex justify-between items-center py-4 px-6 bg-slate-100 dark:bg-slate-700 rounded-t-xl">
        <h4 class="card-title text-lg font-semibold">Roles Table</h4>
    </header>

    <div class="card-body px-6 pb-6">

        <div class="overflow-x-auto dashcode-data-table">
            <table class="min-w-full table-fixed divide-y divide-slate-200 dark:divide-slate-600">
                <thead class="bg-slate-200 dark:bg-slate-700 text-left">
                    <tr>
                        <th class="table-th py-3 text-sm font-bold">No</th>
                        <th class="table-th py-3 text-sm font-bold">Role Name</th>
                        <th class="table-th py-3 text-sm font-bold text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach ($roles as $index => $role)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                            <td class="table-td">{{ $index + 1 }}</td>

                            <td class="table-td">
                                <span class="px-3 py-1 rounded bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300 text-sm font-medium">
                                    {{ $role->name }}
                                </span>
                            </td>

                            <td class="table-td">
                                <div class="flex justify-center space-x-2 rtl:space-x-reverse">

                                    @can('role-edit')
                                        <a href="{{ route('roles.edit', $role->id) }}"
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                            <iconify-icon icon="heroicons:pencil-square" width="22"></iconify-icon>
                                        </a>
                                    @endcan

                                    @can('role-delete')
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition">
                                                <iconify-icon icon="heroicons:trash" width="22"></iconify-icon>
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

@endsection
