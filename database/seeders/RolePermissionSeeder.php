<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create all permissions
        $permissions = ['role-list', 'role-create', 'role-edit', 'role-delete'];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // 2. Create a role and assign all permissions
        $role = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $role->syncPermissions($permissions);

        // 3. Assign this role to your user
        $user = User::find(1); // replace 1 with your user ID
        if ($user) {
            $user->assignRole('Admin');
        }
    }
}
