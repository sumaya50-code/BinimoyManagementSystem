@extends('admin.index')

@section('content')
<div class="mb-5 flex justify-between items-center">
    <ul class="m-0 p-0 list-none flex items-center space-x-2">
        <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
            <a href="index.html">
                <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                <iconify-icon icon="heroicons-outline:chevron-right"
                    class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
            </a>
        </li>
        <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
            User List
        </li>
    </ul>

    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <iconify-icon icon="heroicons-outline:plus" class="mr-1"></iconify-icon> Create New User
    </a>
</div>

<div class="card">
    <header class="card-header noborder">
        <h4 class="card-title">Advanced Table Two</h4>
    </header>
    <div class="card-body px-6 pb-6">
        <div class="overflow-x-auto -mx-6 dashcode-data-table">
            <span class="col-span-8 hidden"></span>
            <span class="col-span-4 hidden"></span>
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                        <thead class="bg-slate-200 dark:bg-slate-700">
                            <tr>
                                <th scope="col" class="table-th">Id</th>
                                <th scope="col" class="table-th">Name</th>
                                <th scope="col" class="table-th">Email</th>
                                <th scope="col" class="table-th">Role</th>
                                <th scope="col" class="table-th">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td class="table-td">{{ $key + 1 }}</td>
                                    <td class="table-td">{{ $item->name }}</td>
                                    <td class="table-td">{{ $item->email }}</td>
                                    <td class="table-td">
                                        @foreach ($item->roles as $role)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="table-td">
                                        <div class="flex space-x-3 rtl:space-x-reverse">
                                            <!-- Show -->
                                            <a href="{{ route('users.show', $item->id) }}" class="action-btn">
                                                <iconify-icon icon="heroicons:eye"></iconify-icon>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('users.edit', $item->id) }}" class="action-btn">
                                                <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('users.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn">
                                                    <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                </button>
                                            </form>
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
