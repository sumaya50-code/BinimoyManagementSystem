@extends('admin.partials.index')

@section('content')

    <!-- Breadcrumb -->
    <div class="sm:p-6 mb-6">
        <div class="flex items-center justify-between">
            <nav class="flex items-center text-sm text-slate-600 dark:text-slate-300 space-x-2">
                <a href="{{ route('members.index') }}" class="flex items-center text-primary-500">
                    <iconify-icon icon="heroicons-outline:home" class="mr-1 w-4 h-4"></iconify-icon>
                    Members
                </a>
                <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400 w-4 h-4"></iconify-icon>
                <span>Add Member</span>
            </nav>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-md rounded-xl p-6">
        <form action="{{ route('members.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Basic Info -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" placeholder="Enter full name"
                           class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label class="font-medium">Guardian Name</label>
                    <input type="text" name="guardian_name" placeholder="Enter guardian name"
                           class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">NID <span class="text-red-500">*</span></label>
                    <input type="text" name="nid" placeholder="National ID"
                           class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label class="font-medium">Phone <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" placeholder="Phone number"
                           class="w-full border px-3 py-2 rounded" required>
                </div>
            </div>

            <div>
                <label class="font-medium">Email</label>
                <input type="email" name="email" placeholder="Email address"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Address -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Present Address <span class="text-red-500">*</span></label>
                    <textarea name="present_address" rows="3"
                              class="w-full border px-3 py-2 rounded"
                              placeholder="Present address" required></textarea>
                </div>

                <div>
                    <label class="font-medium">Permanent Address</label>
                    <textarea name="permanent_address" rows="3"
                              class="w-full border px-3 py-2 rounded"
                              placeholder="Permanent address"></textarea>
                </div>
            </div>

            <!-- Nominee -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Nominee Name</label>
                    <input type="text" name="nominee_name" placeholder="Nominee name"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="font-medium">Nominee Relation</label>
                    <input type="text" name="nominee_relation" placeholder="Relation"
                           class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <!-- Personal Info -->
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="font-medium">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" class="w-full border px-3 py-2 rounded">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="font-medium">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="dob"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="font-medium">Marital Status <span class="text-red-500">*</span></label>
                    <select name="marital_status" class="w-full border px-3 py-2 rounded">
                        <option value="">Select</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Education</label>
                    <input type="text" name="education" placeholder="Education"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="font-medium">Dependents</label>
                    <input type="number" name="dependents" placeholder="Number of dependents"
                           class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <!-- Status -->
            <div>

            <!-- Action -->
            <button class="bg-primary-600 text-white px-4 py-2 rounded">
                Add Member
            </button>
        </form>
    </div>

@endsection
