<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Partner;
use App\Models\ProfitDistribution;
use App\Models\CompanyFund;
use App\Models\Loan;
use App\Models\SavingsTransaction;
use Carbon\Carbon;

class DistributePartnerProfits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:distribute-partner-profits {--period=monthly : Distribution period (monthly/yearly)} {--date= : Specific date for distribution (Y-m-d)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute company profits to partners based on their share percentage and calculate ROI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $period = $this->option('period');
        $specificDate = $this->option('date') ? Carbon::parse($this->option('date')) : now();

        $this->info("Starting profit distribution for period: {$period} on {$specificDate->format('Y-m-d')}");

        // Calculate total company profits for the period
        $totalProfits = $this->calculateTotalProfits($period, $specificDate);

        if ($totalProfits <= 0) {
            $this->warn("No profits to distribute for this period.");
            return;
        }

        $this->info("Total profits to distribute: ৳" . number_format($totalProfits, 2));

        // Get all active partners
        $partners = Partner::where('status', 'active')->get();

        if ($partners->isEmpty()) {
            $this->warn("No active partners found.");
            return;
        }

        $totalShares = $partners->sum('share_percentage');

        if ($totalShares <= 0) {
            $this->warn("No share percentages defined for partners.");
            return;
        }

        foreach ($partners as $partner) {
            $shareAmount = ($partner->share_percentage / $totalShares) * $totalProfits;

            // Calculate ROI (Return on Investment)
            $roi = $this->calculateROI($partner, $shareAmount);

            // Record profit distribution
            ProfitDistribution::create([
                'partner_id' => $partner->id,
                'amount' => $shareAmount,
                'distribution_date' => $specificDate,
                'remarks' => "Profit distribution for {$period} period - ROI: " . number_format($roi, 2) . '%'
            ]);

            // Update partner's total profits
            $partner->increment('total_profits', $shareAmount);

            $this->info("Distributed ৳" . number_format($shareAmount, 2) . " to {$partner->name} (ROI: " . number_format($roi, 2) . "%)");
        }

        $this->info("Profit distribution completed successfully.");
    }

    /**
     * Calculate total company profits for the given period
     */
    private function calculateTotalProfits(string $period, Carbon $date): float
    {
        $startDate = $this->getPeriodStartDate($period, $date);

        // Calculate profits from loans (interest income from paid installments)
        $loanInterest = DB::table('loan_installments')
            ->where('status', 'paid')
            ->where('updated_at', '>=', $startDate)
            ->where('updated_at', '<=', $date)
            ->sum('interest_amount');

        // Calculate profits from savings interest paid (this is expense, so subtract)
        $savingsInterestPaid = SavingsTransaction::where('type', 'deposit')
            ->where('remarks', 'like', '%Interest%')
            ->where('transaction_date', '>=', $startDate)
            ->where('transaction_date', '<=', $date)
            ->sum('amount');

        // Other income sources can be added here (fees, penalties, etc.)
        $otherIncome = 0; // Placeholder

        // Calculate total expenses (operational costs, etc.)
        $totalExpenses = 0; // Placeholder - would need expense tracking

        $totalProfits = $loanInterest + $otherIncome - $savingsInterestPaid - $totalExpenses;

        return max(0, $totalProfits); // Ensure non-negative
    }

    /**
     * Calculate ROI for a partner
     */
    private function calculateROI(Partner $partner, float $profitAmount): float
    {
        if ($partner->invested_amount <= 0) {
            return 0;
        }

        // ROI = (Profit / Investment) * 100
        return ($profitAmount / $partner->invested_amount) * 100;
    }

    /**
     * Get the start date for the given period
     */
    private function getPeriodStartDate(string $period, Carbon $date): Carbon
    {
        switch ($period) {
            case 'yearly':
                return $date->copy()->startOfYear();
            case 'monthly':
            default:
                return $date->copy()->startOfMonth();
        }
    }
}
