@extends('admin.partials.index')

@section('content')
    <!-- Page Header / Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('users.index') }}" class="text-primary-500 hover:text-primary-600 transition flex items-center">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Users
            </a>
            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
            <span class="text-slate-600 dark:text-slate-300">Create User</span>
        </nav>
    </div>

    <!-- Create User Form Card -->
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">

            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                        class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500
                               dark:bg-slate-700 dark:text-white"
                        required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="user@example.com"
                        class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500
                               dark:bg-slate-700 dark:text-white"
                        required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500
                               dark:bg-slate-700 dark:text-white"
                        required>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="confirm-password" placeholder="••••••••"
                        class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500
                               dark:bg-slate-700 dark:text-white"
                        required>
                </div>

                <!-- Roles Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                        Assign Roles <span class="text-red-500">*</span>
                    </label>

                    <select name="roles[]" multiple
                        class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500
                               dark:bg-slate-700 dark:text-white"
                        required>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>

                    <p class="text-xs text-slate-500 mt-1">
                        Hold Ctrl (Windows) or Cmd (Mac) to select multiple roles.
                    </p>
                </div>

                <!-- Form Buttons -->
                <div class="flex items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                    <button type="submit" class="btn btn-primary flex items-center">
                        <iconify-icon icon="heroicons-outline:check" class="mr-2"></iconify-icon>
                        Create User
                    </button>

                    <a href="{{ route('users.index') }}" class="btn btn-secondary flex items-center">
                        <iconify-icon icon="heroicons-outline:x" class="mr-2"></iconify-icon>
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection
