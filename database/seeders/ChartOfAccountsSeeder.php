<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartOfAccount;

class ChartOfAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['code'=>'1000','name'=>'Cash on Hand','type'=>'asset'],
            ['code'=>'1010','name'=>'Bank Account','type'=>'asset'],
            ['code'=>'1100','name'=>'Loan Receivable','type'=>'asset'],

            ['code'=>'2000','name'=>'Savings Liability','type'=>'liability'],
            ['code'=>'2100','name'=>'Loan Payable','type'=>'liability'],

            ['code'=>'3000','name'=>'Equity','type'=>'equity'],

            ['code'=>'4000','name'=>'Interest Income','type'=>'income'],
            ['code'=>'4100','name'=>'Penalty Income','type'=>'income'],

            ['code'=>'5000','name'=>'Interest Expense','type'=>'expense'],
            ['code'=>'5001','name'=>'Cash Outflow Expense','type'=>'expense'],
        ];

        foreach ($defaults as $d) {
            ChartOfAccount::firstOrCreate(['code'=>$d['code']], $d);
        }
    }
}
