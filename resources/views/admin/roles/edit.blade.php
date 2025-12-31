@extends('admin.partials.index')

@section('content')
    <div class="container mt-4">
        <div class="mb-6 flex items-center justify-between">
            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('members.index') }}" class="flex items-center text-primary-500 hover:text-primary-600 transition">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                    Members
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
                <span class="text-slate-600 dark:text-slate-300">Edit Role</span>
            </nav>
            <!-- Back Button -->
            <a href="{{ route('roles.index') }}" class="btn btn-secondary px-4 py-2 rounded-lg font-medium flex items-center">
                <iconify-icon icon="heroicons-outline:arrow-left" class="mr-2"></iconify-icon>
                Back
            </a>
        </div>



        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label"><strong>Role Name</strong></label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Assign Permissions</strong></label>
                        <div class="mt-2 mb-2">
                            <input type="checkbox" id="select-all-global-edit" style="width:18px; height:18px;">
                            <label for="select-all-global-edit" style="font-weight:600; margin-left:8px;">Select All
                                Permissions</label>
                        </div>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-3 col-sm-4 col-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permission[]"
                                            value="{{ $permission->name }}" id="perm-{{ $permission->id }}"
                                            @if (in_array($permission->id, $rolePermissions)) checked @endif>
                                        <label class="form-check-label" for="perm-{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i> Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var global = document.getElementById('select-all-global-edit');
            if (global) {
                global.addEventListener('change', function(e) {
                    var checked = e.target.checked;
                    document.querySelectorAll('input[name="permission[]"]').forEach(function(ch) {
                        ch.checked = checked;
                    });
                });
            }
        });
    </script>
@endsection
