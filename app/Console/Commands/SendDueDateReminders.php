<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoanInstallment;
use App\Services\NotificationService;

class SendDueDateReminders extends Command
{
    protected $signature = 'reminders:due-dates';
    protected $description = 'Send reminders for upcoming loan installment due dates';

    public function handle()
    {
        $reminderDays = 3; // Send reminders 3 days before due date
        $upcoming = now()->addDays($reminderDays)->toDateString();

        $installments = LoanInstallment::where('due_date', '<=', $upcoming)
            ->where('due_date', '>=', now()->toDateString())
            ->where('status', 'pending')
            ->with('loan.member')
            ->get();

        foreach ($installments as $inst) {
            $member = $inst->loan->member;
            if ($member) {
                $dueDate = \Carbon\Carbon::parse($inst->due_date)->format('d-m-Y');
                $message = "Reminder: Your loan installment #{$inst->installment_no} (Loan #{$inst->loan_id}) is due on {$dueDate}. Amount: " . number_format($inst->amount, 2);

                NotificationService::send('loan_due_reminder', [$member->email, $member->phone], ['email', 'sms'], $message, ['installment_id' => $inst->id]);

                $this->info("Reminder sent for installment {$inst->id} to member {$member->full_name}");
            }
        }

        $this->info('Due date reminders sent.');
        return 0;
    }
}
