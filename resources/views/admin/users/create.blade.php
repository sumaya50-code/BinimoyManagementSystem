@extends('admin.index')

@section('content')
    <div class="mb-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('users.index') }}" class="flex items-center text-primary-500 hover:text-primary-600 transition">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Users
            </a>
            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
            <span class="text-slate-600 dark:text-slate-300">Create User</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Form -->
        <div>
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow">
                <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name"
                            class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                            placeholder="John Doe" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email"
                            class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                            placeholder="user@example.com" required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password"
                            class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                            placeholder="••••••••" required>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="confirm-password"
                            class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                            placeholder="••••••••" required>
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Assign Roles <span class="text-red-500">*</span>
                        </label>
                        <select name="roles[]"
                            class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                            multiple required>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Hold Ctrl (or Cmd) to select multiple
                            roles.</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <button type="submit" class="btn btn-primary px-6 py-2 rounded-lg font-medium flex items-center">
                            <iconify-icon icon="heroicons-outline:check" class="mr-2"></iconify-icon>
                            Create User
                        </button>
                        <a href="{{ route('users.index') }}"
                            class="btn btn-secondary px-6 py-2 rounded-lg font-medium flex items-center">
                            <iconify-icon icon="heroicons-outline:x" class="mr-2"></iconify-icon>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
