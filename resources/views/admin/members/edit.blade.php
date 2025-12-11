@extends('admin.index')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-6 sm:py-8">
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center justify-between">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('members.index') }}" class="flex items-center text-primary-500 hover:text-primary-600 transition">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
                Members
            </a>
            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
            <span class="text-slate-600 dark:text-slate-300">Edit Member</span>
        </nav>

        <!-- Back Button -->
        <a href="{{ route('members.index') }}" class="btn btn-secondary">
            <iconify-icon icon="heroicons-outline:arrow-left" class="mr-1"></iconify-icon>
            Back
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-6 sm:mb-8">Edit Member</h1>

        <form action="{{ route('members.update', $member->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name & NID Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Name</label>
                    <input type="text" name="name" class="w-full px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition text-sm sm:text-base" value="{{ $member->name }}" required>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NID</label>
                    <input type="text" name="nid" class="w-full px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition text-sm sm:text-base" value="{{ $member->nid }}" required>
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address</label>
                <textarea name="address" rows="3" class="w-full px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition text-sm sm:text-base" required>{{ $member->address }}</textarea>
            </div>

            <!-- Phone & Status Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                    <input type="text" name="phone" class="w-full px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition text-sm sm:text-base" value="{{ $member->phone }}" required>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="w-full px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition text-sm sm:text-base" required>
                        <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Nominee Info Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nominee Name</label>
                    <input type="text" name="nominee_name" class="w-full px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition text-sm sm:text-base" value="{{ $member->nominee_name }}">
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nominee Relation</label>
                    <input type="text" name="nominee_relation" class="w-full px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition text-sm sm:text-base" value="{{ $member->nominee_relation }}">
                </div>
            </div>

            <!-- Submit Button -->
            <div class=" justify-end flex mt-4">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md text-sm sm:text-base">
                    <iconify-icon icon="heroicons-outline:check" class="mr-2"></iconify-icon>
                    Update Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
