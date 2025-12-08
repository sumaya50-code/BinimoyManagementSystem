@extends('admin.index')

@section('content')
<div class="mb-5">
    <ul class="m-0 p-0 list-none flex items-center space-x-2">
        <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter">
            <a href="{{ route('members.index') }}">
                <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                <iconify-icon icon="heroicons-outline:chevron-right"
                    class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
            </a>
        </li>
        <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
            Member Profile
        </li>
    </ul>
</div>

<div class="card p-6">
    <header class="card-header noborder mb-4">
        <h4 class="card-title text-xl font-semibold">
            {{ $member->name }} – Profile
        </h4>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Left Column -->
        <div class="space-y-4">
            <div>
                <p class="text-sm text-gray-500">Full Name</p>
                <p class="text-base font-semibold">{{ $member->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Address</p>
                <p class="text-base font-semibold">{{ $member->address }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">NID Number</p>
                <p class="text-base font-semibold">{{ $member->nid }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Phone Number</p>
                <p class="text-base font-semibold">{{ $member->phone }}</p>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-4">

            <div>
                <p class="text-sm text-gray-500">Nominee Name</p>
                <p class="text-base font-semibold">{{ $member->nominee_name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Nominee Relation</p>
                <p class="text-base font-semibold">{{ $member->nominee_relation }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="inline-block px-3 py-1 rounded text-xs font-medium
                    {{ $member->status == 'Active'
                        ? 'bg-green-100 text-green-700'
                        : 'bg-red-100 text-red-700' }}">
                    {{ $member->status }}
                </span>
            </div>

        </div>

    </div>

    <div class="mt-6 flex space-x-3">
        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary">
            <iconify-icon icon="heroicons:pencil-square" class="mr-1"></iconify-icon>
            Edit Member
        </a>

        <a href="{{ route('members.index') }}" class="btn btn-secondary">
            <iconify-icon icon="heroicons:arrow-left" class="mr-1"></iconify-icon>
            Back to List
        </a>
    </div>

</div>
@endsection
