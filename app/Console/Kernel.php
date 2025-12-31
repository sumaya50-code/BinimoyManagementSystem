<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Custom commands
        \App\Console\Commands\BackfillSavingsAccountNo::class,
        \App\Console\Commands\TestSavingsFlow::class,
        \App\Console\Commands\ProcessLoanPenalties::class,
        \App\Console\Commands\TestLedgerFlow::class,
        \App\Console\Commands\DistributePartnerProfits::class,
        \App\Console\Commands\SendDueDateReminders::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send due date reminders daily
        $schedule->command('reminders:due-dates')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
