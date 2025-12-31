<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use App\Models\SavingsWithdrawalRequest;
use App\Models\CompanyFund;

class TestSavingsFlow extends Command
{
    protected $signature = 'bns:test-savings-flow';
    protected $description = 'Create test member/account, deposit, approve, request withdrawal and approve';

    public function handle()
    {
        $m = Member::create([
            'member_no' => 'M99999',
            'name' => 'Test User',
            'nid' => 'NIDTEST999',
            'phone' => '0123456789',
            'present_address' => 'Test Address'
        ]);

        $this->info('Member created: ' . $m->id);

        $a = SavingsAccount::create(['member_id' => $m->id, 'balance' => 0, 'interest_rate' => 5]);
        $this->info('Account created: ' . $a->account_no . ' (id ' . $a->id . ')');

        $txn = SavingsTransaction::create([
            'savings_account_id' => $a->id,
            'type' => 'deposit',
            'amount' => 500,
            'remarks' => 'Test deposit',
            'status' => 'pending',
            'transaction_date' => now()
        ]);

        $this->info('Deposit txn created (pending): ' . $txn->id);

        // Approve deposit
        $txn->update(['status' => 'approved']);
        $a->increment('balance', $txn->amount);
        $a->refresh();
        $this->info('After approve - account balance: ' . $a->balance);

        // Create withdrawal request
        $wr = SavingsWithdrawalRequest::create(['member_id' => $m->id, 'amount' => 200, 'status' => 'pending']);
        $this->info('Withdrawal request created: ' . $wr->id . ' amount ' . $wr->amount);

        $company = CompanyFund::firstOrCreate([], ['balance' => 100000]);
        $this->info('Company fund balance before: ' . $company->balance);

        if ($wr->amount > $a->balance) {
            $this->error('Cannot approve: insufficient account balance');
            return 1;
        }

        if ($company->balance < $wr->amount) {
            $this->error('Cannot approve: insufficient company fund');
            return 1;
        }

        // Approve
        $wr->update(['status' => 'approved', 'approved_by' => 1, 'approved_at' => now()]);
        $a->decrement('balance', $wr->amount);
        $company->decrement('balance', $wr->amount);
        $a->refresh(); $company->refresh();

        $this->info('After approval - account balance: ' . $a->balance . ', company: ' . $company->balance);

        return 0;
    }
}
