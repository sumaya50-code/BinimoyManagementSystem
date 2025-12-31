<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use App\Models\Journal;

class TestLedgerFlow extends Command
{
    protected $signature = 'test:ledger';
    protected $description = 'Create sample savings txn and approve to test ledger posting';

    public function handle()
    {
        $this->info('Starting test ledger flow');

        $member = Member::first() ?? Member::create([
            'member_no' => 'M_TEST',
            'name' => 'Ledger Test',
            'nid' => 'N_TEST_'.time(),
            'phone' => '0000000000',
            'present_address' => 'Test',
        ]);

        $account = $member->savingsAccounts()->first() ?? $member->savingsAccounts()->create([
            'balance' => 0
        ]);

        $txn = SavingsTransaction::create([
            'savings_account_id' => $account->id,
            'type' => 'deposit',
            'amount' => 150.00,
            'remarks' => 'Test deposit',
            'status' => 'pending',
            'transaction_date' => now(),
        ]);

        $this->info('Created txn: '.$txn->id);

        $txn->update(['status' => 'approved']);

        $journal = Journal::where('transactionable_type', SavingsTransaction::class)
            ->where('transactionable_id', $txn->id)
            ->first();

        if ($journal) {
            $this->info('Journal posted: '.$journal->id);
        } else {
            $this->error('Journal not found for txn');
        }

        return 0;
    }
}
