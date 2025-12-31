<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyFund;

class CompanyFundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use configurable initial balance from .env (defaults to 100000.00)
        $initial = floatval(env('COMPANY_FUND_INITIAL', 00));
        CompanyFund::firstOrCreate([], ['balance' => $initial]);
    }
}
