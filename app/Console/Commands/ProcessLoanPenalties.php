<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoanInstallment;

class ProcessLoanPenalties extends Command
{
    protected $signature = 'bns:process-penalties';
    protected $description = 'Process overdue loan installments and apply penalties';

    public function handle()
    {
        $today = now()->toDateString();
        $overdue = LoanInstallment::where('due_date', '<', $today)
            ->where('status', 'pending')
            ->get();

        foreach ($overdue as $inst) {
            $inst->status = 'overdue';
            // simple penalty: penalty_rate percent of installment amount per period (loan-level rate)
            $penaltyRate = $inst->loan->penalty_rate ?? 0.5;
            $penalty = round(($inst->amount * $penaltyRate) / 100, 2);
            $inst->penalty_amount = $inst->penalty_amount + $penalty;
            $inst->save();

            // Notify member about overdue installment
            $member = $inst->loan->member;
            if ($member) {
                $message = 'Your loan installment #'.$inst->installment_no.' (Loan #'.$inst->loan_id.') is overdue. Penalty applied: '.number_format($penalty,2);
                \App\Services\NotificationService::send('loan_installment_overdue', [$member->email, $member->phone], ['email','sms'], $message, ['installment_id'=>$inst->id]);
            }

            $this->info("Installment {$inst->id} marked overdue, penalty applied: {$penalty}");
        }

        $this->info('Penalty processing complete.');
        return 0;
    }
}
