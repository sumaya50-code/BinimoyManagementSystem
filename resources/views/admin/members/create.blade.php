@extends('admin.index')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('members.index') }}" class="flex items-center text-primary-500 hover:text-primary-600 transition">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Members
            </a>
            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
            <span class="text-slate-600 dark:text-slate-300">Create Member</span>
        </nav>
        <!-- Back Button -->
        <a href="{{ route('members.index') }}" class="btn btn-secondary px-4 py-2 rounded-lg font-medium flex items-center">
            <iconify-icon icon="heroicons-outline:arrow-left" class="mr-2"></iconify-icon>
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Form -->
        <div>
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow">
                <form action="{{ route('members.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white" placeholder="Member Name" required>
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Address <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="address" class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white" placeholder="Enter address" required>
                    </div>

                    <!-- NID -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            NID <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nid" class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white" placeholder="National ID" required>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Phone <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="phone" class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white" placeholder="Phone number" required>
                    </div>

                    <!-- Nominee Name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Nominee Name
                        </label>
                        <input type="text" name="nominee_name" class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white" placeholder="Nominee name">
                    </div>

                    <!-- Nominee Relation -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Nominee Relation
                        </label>
                        <input type="text" name="nominee_relation" class="form-control w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white" placeholder="Relation">
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <button type="submit" class="btn btn-primary px-6 py-2 rounded-lg font-medium flex items-center">
                            <iconify-icon icon="heroicons-outline:check" class="mr-2"></iconify-icon>
                            Save
                        </button>
                        <a href="{{ route('members.index') }}" class="btn btn-secondary px-6 py-2 rounded-lg font-medium flex items-center">
                            <iconify-icon icon="heroicons-outline:x" class="mr-2"></iconify-icon>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
