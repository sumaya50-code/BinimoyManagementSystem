@extends('admin.index')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('users.index') }}" class="flex items-center text-primary-500 hover:text-primary-600 transition">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Users
            </a>
            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
            <span class="text-slate-600 dark:text-slate-300">Edit User</span>
        </nav>

        <!-- Back Button -->
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <iconify-icon icon="heroicons-outline:arrow-left" class="mr-1"></iconify-icon>
            Back
        </a>
    </div>


    <div class="card">
        <header class="card-header noborder">
            <h4 class="card-title">Update User Information</h4>
        </header>

        <div class="card-body px-6 pb-6">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Name -->
                    <div>
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                            required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="form-label">Password (Optional)</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Leave blank to keep current password">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm-password" class="form-control"
                            placeholder="Leave blank if not changing">
                    </div>

                    <!-- Role -->
                    <div class="md:col-span-2">
                        <label class="form-label">Assign Role</label>
                        <select name="roles[]" class="form-control" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @if (in_array($role, $userRoles)) selected @endif>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">
                            Hold CTRL (Windows) or CMD (Mac) to select multiple.
                        </p>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="btn btn-primary">
                        <iconify-icon icon="heroicons-outline:check" class="mr-1"></iconify-icon>
                        Update User
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
