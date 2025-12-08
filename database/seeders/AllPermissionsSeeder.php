<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AllPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Define modules and actions
        $modules = [
            'role',
            'product',
            'user',
            'member',
            'loan',
            'saving',
            'withdrawal'
        ];

        $actions = ['list', 'view', 'create', 'edit', 'delete'];

        $allPermissions = [];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $name = $module . '-' . $action;
                Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
                $allPermissions[] = $name;
            }
        }

        // Create Admin role and assign all permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($allPermissions);

        // Assign Admin role to first user if exists
        $user = User::find(1);
        if ($user) {
            $user->assignRole($adminRole);
            $this->command->info('Assigned Admin role to user id=1');
        } else {
            $this->command->info('No user with id=1 found; create a user and assign Admin role manually.');
        }
    }
}
