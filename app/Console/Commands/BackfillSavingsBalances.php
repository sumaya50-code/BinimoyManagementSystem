<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;

class BackfillSavingsBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:savings-balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill savings account balances based on approved transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $accounts = SavingsAccount::all();

        foreach ($accounts as $account) {
            $balance = $account->transactions()
                ->where('status', 'approved')
                ->selectRaw('SUM(CASE WHEN type = "deposit" THEN amount ELSE -amount END) as calculated_balance')
                ->value('calculated_balance') ?? 0;

            $account->update(['balance' => $balance]);
            $this->info("Updated balance for account {$account->id} to {$balance}");
        }

        $this->info('Backfill completed');
    }
}
