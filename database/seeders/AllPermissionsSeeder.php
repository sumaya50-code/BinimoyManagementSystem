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
        // Define modules and their specific actions
        $modulesWithActions = [
            'role' => ['list', 'view', 'create', 'edit', 'delete'],
            'user' => ['list', 'view', 'create', 'edit', 'delete'],
            'member' => ['list', 'view', 'create', 'edit', 'delete'],
            'loan' => ['list', 'view', 'create', 'edit', 'delete'],
            'saving' => [
                'list',             // view savings dashboard
                'view',             // view account details
                'create',           // deposit entry
                'edit',             // edit deposit if needed
                'delete',           // delete transaction
                'approve',          // approve deposit
                'post-interest',    // post monthly interest
                'withdraw',         // submit withdrawal request
                'approve-withdraw', // approve withdrawal request
                'voucher'           // generate withdrawal voucher
            ],
            'partner' => ['list', 'view', 'create', 'edit', 'delete'],
            'investment' => ['list', 'view', 'create', 'approve'],
            'withdrawal' => ['list', 'view', 'create', 'approve'],
            'cash-asset' => ['list', 'view', 'create', 'edit', 'delete'],
            'companyfund' => ['view'],
            'report' => ['view'],
            'notification' => ['view'],
            'audit' => ['view'],
            'loan-proposal' => ['list', 'view', 'create', 'edit', 'delete', 'approve', 'audit', 'manager-review', 'area-approve'],
            'loan-installments' => [],
            'loan-collections' => [],
        ];

        $allPermissions = [];

        // Create permissions
        foreach ($modulesWithActions as $module => $actions) {
            if (empty($actions)) {
                $name = $module;
                Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
                $allPermissions[] = $name;
            } else {
                foreach ($actions as $action) {
                    $name = $module . '-' . $action;
                    Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
                    $allPermissions[] = $name;
                }
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

        $this->command->info('All permissions seeded successfully.');
    }
}
