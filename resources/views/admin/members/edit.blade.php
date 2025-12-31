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
                <span>Edit Member</span>
            </nav>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-md rounded-xl p-6">
        <form action="{{ route('members.update', $member->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Basic Info -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $member->name) }}"
                           class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label class="font-medium">Guardian Name</label>
                    <input type="text" name="guardian_name"
                           value="{{ old('guardian_name', $member->guardian_name) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">NID</label>
                    <input type="text" name="nid" value="{{ old('nid', $member->nid) }}"
                           class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label class="font-medium">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                           class="w-full border px-3 py-2 rounded" required>
                </div>
            </div>

            <div>
                <label class="font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Address -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Present Address</label>
                    <textarea name="present_address" rows="3"
                              class="w-full border px-3 py-2 rounded" required>{{ old('present_address', $member->present_address) }}</textarea>
                </div>

                <div>
                    <label class="font-medium">Permanent Address</label>
                    <textarea name="permanent_address" rows="3"
                              class="w-full border px-3 py-2 rounded">{{ old('permanent_address', $member->permanent_address) }}</textarea>
                </div>
            </div>

            <!-- Nominee -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Nominee Name</label>
                    <input type="text" name="nominee_name"
                           value="{{ old('nominee_name', $member->nominee_name) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="font-medium">Nominee Relation</label>
                    <input type="text" name="nominee_relation"
                           value="{{ old('nominee_relation', $member->nominee_relation) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <!-- Personal Info -->
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="font-medium">Gender</label>
                    <select name="gender" class="w-full border px-3 py-2 rounded">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ $member->gender=='Male'?'selected':'' }}>Male</option>
                        <option value="Female" {{ $member->gender=='Female'?'selected':'' }}>Female</option>
                        <option value="Other" {{ $member->gender=='Other'?'selected':'' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="font-medium">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', $member->dob) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="font-medium">Marital Status</label>
                    <select name="marital_status" class="w-full border px-3 py-2 rounded">
                        <option value="">Select</option>
                        <option value="Single" {{ $member->marital_status=='Single'?'selected':'' }}>Single</option>
                        <option value="Married" {{ $member->marital_status=='Married'?'selected':'' }}>Married</option>
                        <option value="Divorced" {{ $member->marital_status=='Divorced'?'selected':'' }}>Divorced</option>
                        <option value="Widowed" {{ $member->marital_status=='Widowed'?'selected':'' }}>Widowed</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Education</label>
                    <input type="text" name="education"
                           value="{{ old('education', $member->education) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="font-medium">Dependents</label>
                    <input type="number" name="dependents"
                           value="{{ old('dependents', $member->dependents) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="font-medium">Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded">
                    <option value="Active" {{ $member->status=='Active'?'selected':'' }}>Active</option>
                    <option value="Inactive" {{ $member->status=='Inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>

            <!-- Action -->
            <button class="bg-primary-600 text-white px-4 py-2 rounded">
                Update Member
            </button>
        </form>
    </div>

@endsection
