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
            'User' => ['user-list', 'user-create', 'user-edit', 'user-delete'],
            'Member' => ['member-list', 'member-create', 'member-edit', 'member-delete'],

            // Savings Module Permissions
            'Saving' => [
                'saving-list',          // view accounts & dashboard
                'saving-create',        // create deposit
                'saving-approve',       // approve deposits
                'saving-edit',          // edit deposit if needed
                'saving-delete',        // delete transaction
                'saving-post-interest', // post monthly interest
                'saving-withdraw',      // submit withdrawal request
                'saving-approve-withdraw', // approve withdrawal request
                'saving-voucher',       // generate withdrawal voucher
            ],

            // Loan Module Permissions
            'Loan' => [
                'loan-list',       // index
                'loan-create',     // create/store
                'loan-edit',       // edit/update
                'loan-delete',     // destroy
            ],

            // Partners Module Permissions
            'Partner' => ['partner-list', 'partner-create', 'partner-edit', 'partner-delete'],

            // Investment Module Permissions
            'Investment' => ['investment-list', 'investment-create', 'investment-approve'],

            // Withdrawal Module Permissions
            'Withdrawal' => ['withdrawal-list', 'withdrawal-create', 'withdrawal-approve'],

            // Cash Asset Module Permissions
            'Cash Asset' => ['cash-asset-list', 'cash-asset-create', 'cash-asset-edit', 'cash-asset-delete'],

            // Company Fund Module Permissions
            'Company Fund' => ['companyfund-view'],

            // Report Module Permissions
            'Report' => ['report-view'],

            // Notification Module Permissions
            'Notification' => ['notification-view'],

            // Audit Module Permissions
            'Audit' => ['audit-view'],

            // Loan Proposal Module Permissions
            'Loan Proposal' => ['loan-proposal-list', 'loan-proposal-create', 'loan-proposal-edit', 'loan-proposal-delete', 'loan-proposal-approve', 'loan-proposal-audit', 'loan-proposal-manager-review', 'loan-proposal-area-approve'],

            // Loan Installments Module Permissions
            'Loan Installments' => ['loan-installments'],

            // Loan Collections Module Permissions
            'Loan Collections' => ['loan-collections'],
        ];

        foreach ($permissions as $group => $perms) {
            foreach ($perms as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
        }
    }
}
