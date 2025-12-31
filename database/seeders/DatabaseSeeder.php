<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CreateAdminUserSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(AdminPermissionSeeder::class);

        // Seed initial company fund
        $this->call(CompanyFundSeeder::class);

        // Seed default chart of accounts for ledger
        $this->call(ChartOfAccountsSeeder::class);
    }
}
