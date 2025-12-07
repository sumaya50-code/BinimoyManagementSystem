@extends('admin.index')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Role</h2>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('roles.index') }}">
            <i class="fa fa-arrow-left"></i> Back
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
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-3 col-sm-4 col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="permission[]"
                                           value="{{ $permission->name }}"
                                           id="perm-{{ $permission->id }}"
                                           @if(in_array($permission->id, $rolePermissions)) checked @endif>
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
@endsection
