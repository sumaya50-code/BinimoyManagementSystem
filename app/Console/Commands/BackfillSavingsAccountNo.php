<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SavingsAccount;

class BackfillSavingsAccountNo extends Command
{
    protected $signature = 'bns:backfill-account-no';
    protected $description = 'Backfill missing account_no for savings accounts';

    public function handle()
    {
        $accounts = SavingsAccount::whereNull('account_no')->get();
        $this->info('Found ' . $accounts->count() . ' accounts to update.');
        foreach ($accounts as $account) {
            $account->update(['account_no' => 'SA' . str_pad($account->id, 6, '0', STR_PAD_LEFT)]);
        }
        $this->info('Backfill complete.');
        return 0;
    }
}
