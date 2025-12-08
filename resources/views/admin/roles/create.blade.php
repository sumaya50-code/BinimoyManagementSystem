@extends('admin.index')

@section('content')
<div class="mb-6 flex items-center justify-between">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('members.index') }}" class="flex items-center text-primary-500 hover:text-primary-600 transition">
                <iconify-icon icon="heroicons-outline:home" class="mr-1"></iconify-icon>
               Roles
            </a>
            <iconify-icon icon="heroicons-outline:chevron-right" class="text-slate-400"></iconify-icon>
            <span class="text-slate-600 dark:text-slate-300">Create Role</span>
        </nav>
        <!-- Back Button -->
        <a href="{{ route('roles.index') }}" class="btn btn-secondary px-4 py-2 rounded-lg font-medium flex items-center">
            <iconify-icon icon="heroicons-outline:arrow-left" class="mr-2"></iconify-icon>
            Back
        </a>
    </div>
    <style>
        /* Plus icon */
        .accordian-wrapper .accordion-button::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'%3E%3Cpath d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/%3E%3C/svg%3E");
            transition: all .5s;
        }

        /* Minus icon on expand */
        .accordian-wrapper .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-dash' viewBox='0 0 16 16'%3E%3Cpath d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/%3E%3C/svg%3E");
        }

        .accordian-wrapper .accordion-button:not(.collapsed) {
            color: #0c63e4;
            background: transparent;
            box-shadow: none;
        }

        .accordian-wrapper ul li {
            border-top: 1px solid #ddd;
            padding: 1rem 1.25rem;
        }
    </style>

    <div class="container">

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <input type="checkbox" id="select-all-global" style="width:18px; height:18px;">
                <label for="select-all-global" style="font-weight:600; margin-left:8px;">Select All Permissions</label>
            </div>

            <!-- Role Name -->
            <div class="form-group mb-3">
                <label for="name" style="font-size:16px; font-weight:600;">Role Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Role Name"
                    style="border:1px solid #bbb; padding:10px;">
            </div>

            @php
                $chunks = $permissions->chunk(2);
            @endphp

            @foreach ($chunks as $chunk)
                <div class="row mb-3">

                    @foreach ($chunk as $module => $perms)
                        <div class="col-md-6">
                            <div class="card shadow-sm" data-module="{{ $module }}" style="border-radius:6px;">
                                <div class="card-header d-flex justify-content-between align-items-center"
                                    style="background:#f8f9fa; font-weight:bold;">
                                    <span>{{ ucfirst($module) }} Permissions</span>
                                    <div>
                                        <input type="checkbox" class="select-module" data-module="{{ $module }}"
                                            id="module-{{ $module }}" style="width:18px; height:18px;">
                                        <label for="module-{{ $module }}" class="mb-0"
                                            style="margin-left:6px; font-weight:600;">All</label>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <table class="table table-bordered mb-0">
                                        <thead style="background:#f1f1f1;">
                                            <tr>
                                                <th style="width:80px;">Select</th>
                                                <th>Permission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($perms as $permission)
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="permission[]"
                                                            value="{{ $permission->name }}" id="perm-{{ $permission->id }}"
                                                            style="width:18px; height:18px;">
                                                    </td>
                                                    <td style="padding-top:12px;">
                                                        {{ $permission->name }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            @endforeach

            <button type="submit" class="btn btn-primary mt-3" style="padding:10px 20px; font-weight:600;">
                Create Role
            </button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var global = document.getElementById('select-all-global');
            if (global) {
                global.addEventListener('change', function(e) {
                    var checked = e.target.checked;
                    document.querySelectorAll('input[name="permission[]"]').forEach(function(ch) {
                        ch.checked = checked;
                    });
                    document.querySelectorAll('.select-module').forEach(function(m) {
                        m.checked = checked;
                    });
                });
            }

            document.querySelectorAll('.select-module').forEach(function(moduleCheckbox) {
                moduleCheckbox.addEventListener('change', function(e) {
                    var mod = moduleCheckbox.dataset.module;
                    var checked = moduleCheckbox.checked;
                    var container = document.querySelector('div.card[data-module="' + mod + '"]');
                    if (container) {
                        container.querySelectorAll('input[name="permission[]"]').forEach(function(
                            ch) {
                            ch.checked = checked;
                        });
                    }
                    // if any module is unchecked, unset global
                    if (!checked && global) global.checked = false;
                    // if all module checkboxes are checked, set global
                    if (global) {
                        var allModulesChecked = Array.from(document.querySelectorAll(
                            '.select-module')).every(function(m) {
                            return m.checked;
                        });
                        global.checked = allModulesChecked;
                    }
                });
            });
        });
    </script>
@endsection
