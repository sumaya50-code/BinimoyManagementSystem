<?php

namespace App\Services;

use App\Models\Journal;
use App\Models\LedgerEntry;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;

class LedgerService
{
    /**
     * Post a journal with entries. Lines: [['account_code'|'account_id', 'debit'=>x, 'credit'=>y, 'description'=>...], ...]
     */
    public static function postJournal(array $lines, string $narration = null, $transactionable = null, $createdBy = null)
    {
        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($lines as $l) {
            $totalDebit += floatval($l['debit'] ?? 0);
            $totalCredit += floatval($l['credit'] ?? 0);
        }

        if (round($totalDebit,2) !== round($totalCredit,2)) {
            throw new \Exception('Journal is not balanced: debits != credits ('. $totalDebit .' != '. $totalCredit .')');
        }

        return DB::transaction(function() use ($lines, $narration, $transactionable, $createdBy){
            $journal = Journal::create([
                'journal_type' => 'auto',
                'transactionable_id' => $transactionable ? $transactionable->id : null,
                'transactionable_type' => $transactionable ? get_class($transactionable) : null,
                'narration' => $narration,
                'created_by' => $createdBy,
                'posted_at' => now(),
            ]);

            foreach ($lines as $l) {
                $account = null;
                if (isset($l['account_code'])) {
                    $account = ChartOfAccount::where('code',$l['account_code'])->first();
                } elseif (isset($l['account_id'])) {
                    $account = ChartOfAccount::find($l['account_id']);
                }

                if (!$account) {
                    throw new \Exception('Account not found for ledger line');
                }

                LedgerEntry::create([
                    'journal_id' => $journal->id,
                    'account_id' => $account->id,
                    'debit' => $l['debit'] ?? 0,
                    'credit' => $l['credit'] ?? 0,
                    'description' => $l['description'] ?? null,
                ]);
            }

            return $journal;
        });
    }

    public static function postSavingsTransaction(\App\Models\SavingsTransaction $txn, $createdBy = null)
    {
        // Ensure no existing journal for this transaction
        $exists = Journal::where('transactionable_type', get_class($txn))
            ->where('transactionable_id', $txn->id)
            ->exists();

        if ($exists) return null;

        $amount = floatval($txn->amount);
        $narration = 'Savings txn #'. $txn->id .' ('.$txn->type.')';

        if ($txn->type === 'deposit') {
            $lines = [
                ['account_code'=>'1000','debit'=>$amount,'description'=>'Cash/Bank (deposit)'],
                ['account_code'=>'2000','credit'=>$amount,'description'=>'Savings Liability'],
            ];
        } elseif ($txn->type === 'withdrawal') {
            $lines = [
                ['account_code'=>'2000','debit'=>$amount,'description'=>'Reduce Savings Liability'],
                ['account_code'=>'1000','credit'=>$amount,'description'=>'Cash/Bank (withdrawal)'],
            ];
        } elseif ($txn->type === 'interest') {
            $lines = [
                ['account_code'=>'5000','debit'=>$amount,'description'=>'Interest Expense'],
                ['account_code'=>'2000','credit'=>$amount,'description'=>'Interest credited to savings'],
            ];
        } else {
            // fallback: no posting
            return null;
        }

        return self::postJournal($lines, $narration, $txn, $createdBy);
    }

    public static function postCashTransaction(\App\Models\CashTransaction $txn, $createdBy = null)
    {
        $exists = Journal::where('transactionable_type', get_class($txn))
            ->where('transactionable_id', $txn->id)
            ->exists();

        if ($exists) return null;

        $amount = floatval($txn->amount);
        $narration = 'Cash txn #'. $txn->id .' ('.$txn->type.')';

        if ($txn->type === 'inflow') {
            $lines = [
                ['account_code'=>'1000','debit'=>$amount,'description'=>'Cash inflow'],
                ['account_code'=>'4000','credit'=>$amount,'description'=>'Income/Cash inflow'],
            ];
        } else {
            $lines = [
                ['account_code'=>'5001','debit'=>$amount,'description'=>'Expense/Cash outflow'],
                ['account_code'=>'1000','credit'=>$amount,'description'=>'Cash outflow'],
            ];
        }

        return self::postJournal($lines, $narration, $txn, $createdBy);
    }
}
