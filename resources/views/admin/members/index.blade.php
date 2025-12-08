@extends('admin.index')

@section('content')
    <div class="mb-5 flex justify-between items-center">
        <ul class="m-0 p-0 list-none flex items-center space-x-2">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter">
                <a href="#">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                Members Management
            </li>
        </ul>

        @can('member-create')
            <a href="{{ route('members.create') }}" class="btn btn-primary">
                <iconify-icon icon="heroicons-outline:plus" class="mr-1"></iconify-icon> Add Member
            </a>
        @endcan
    </div>

    <div class="card">
        <header class="card-header noborder">
            <h4 class="card-title">Members List</h4>
        </header>

        <div class="card-body px-6 pb-6">
            <div class="overflow-x-auto -mx-6 dashcode-data-table">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                            <thead class="bg-slate-200 dark:bg-slate-700">
                                <tr>
                                    <th class="table-th">Name</th>
                                    <th class="table-th">NID</th>
                                    <th class="table-th">Phone</th>
                                    <th class="table-th">Status</th>
                                    <th class="table-th">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @foreach ($members as $member)
                                    <tr>
                                        <td class="table-td">{{ $member->name }}</td>
                                        <td class="table-td">{{ $member->nid }}</td>
                                        <td class="table-td">{{ $member->phone }}</td>

                                        <td class="table-td">
                                            <a href="{{ route('members.toggleStatus', $member->id) }}"
                                                class="inline-block px-3 py-1 rounded text-xs font-medium
                                        {{ $member->status == 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $member->status }}
                                            </a>
                                        </td>

                                        <td class="table-td">
                                            <div class="flex space-x-3 rtl:space-x-reverse">

                                                <!-- View -->
                                                @can('member-view')
                                                    <a href="{{ route('members.show', $member->id) }}" class="action-btn">
                                                        <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                    </a>
                                                @endcan

                                                <!-- Edit -->
                                                @can('member-edit')
                                                    <a href="{{ route('members.edit', $member->id) }}" class="action-btn">
                                                        <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                    </a>
                                                @endcan

                                                <!-- Delete -->
                                                @can('member-delete')
                                                    <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                                        onsubmit="return confirm('Delete member?');">
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
