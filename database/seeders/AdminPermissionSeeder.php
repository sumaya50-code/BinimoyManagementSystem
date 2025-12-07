<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Get the admin user (replace 1 with your user ID)
        $user = User::find(1);
        if (!$user) {
            $this->command->info('User not found!');
            return;
        }

        // Create a role (if not exists)
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Get all permissions (or create them if not exist)
        $permissions = ['role-list','role-create','role-edit','role-delete'];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign all permissions to the role
        $role->syncPermissions(Permission::all());

        // Assign the role to the user
        $user->assignRole($role);

        $this->command->info('Admin user now has all role permissions!');
    }
}
