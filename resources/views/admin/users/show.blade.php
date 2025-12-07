@extends('admin.index')

@section('content')
<div class="mb-5">
    <ul class="m-0 p-0 list-none">
        <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter">
            <a href="{{ route('users.index') }}">
                <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                <iconify-icon icon="heroicons-outline:chevron-right" class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
            </a>
        </li>
        <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">User Details</li>
    </ul>
</div>

<div class="card">
    <header class="card-header noborder">
        <h4 class="card-title">User Details</h4>
    </header>
    <div class="card-body px-6 pb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <strong>Name:</strong>
                <p>{{ $user->name }}</p>
            </div>

            <div>
                <strong>Email:</strong>
                <p>{{ $user->email }}</p>
            </div>

            <div class="col-span-2">
                <strong>Roles:</strong>
                <p>
                    @foreach ($user->roles as $role)
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">{{ $role->name }}</span>
                    @endforeach
                </p>
            </div>

        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
