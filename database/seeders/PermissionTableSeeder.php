<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'Role' => ['role-list', 'role-create', 'role-edit', 'role-delete'],
            'Product' => ['product-list', 'product-create', 'product-edit', 'product-delete'],
            'User' => ['user-list', 'user-create', 'user-edit', 'user-delete'],
            'Member' => ['member-list', 'member-create', 'member-edit', 'member-delete'],

            // Savings Module Permissions
            'Saving' => [
                'saving-list',     // index
                'saving-create',   // create/store
                'saving-edit',     // edit/update
                'saving-delete',   // destroy
            ],

            // Loan Module Permissions
            'Loan' => [
                'loan-list',       // index
                'loan-create',     // create/store
                'loan-edit',       // edit/update
                'loan-delete',     // destroy
            ],
        ];

        foreach ($permissions as $group => $perms) {
            foreach ($perms as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
        }
    }
}
