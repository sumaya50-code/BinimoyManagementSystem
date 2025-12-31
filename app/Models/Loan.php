<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class Loan extends Model
{
    use Auditable;
    protected $fillable = ['loan_proposal_id', 'member_id', 'loan_amount', 'disbursed_amount', 'remaining_amount', 'interest_rate', 'penalty_rate', 'installment_count', 'installment_type', 'status', 'disbursement_date', 'remarks'];

    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

    public function loanProposal()
    {
        return $this->belongsTo(LoanProposal::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function installments()
    {
        return $this->hasMany(LoanInstallment::class);
    }

    /**
     * Generate a simple installment schedule evenly splitting principal + interest
     * This does not account for floating interest types; it's a straightforward amortized split.
     */
    public function generateInstallments($startDate = null)
    {
        $start = $startDate ? \Carbon\Carbon::parse($startDate) : now();
        $count = (int) $this->installment_count;
        if ($count <= 0) return;

        // total amount (simple interest calculation)
        $principal = $this->disbursed_amount;
        $monthlyRate = ($this->interest_rate / 100) / 12;
        $totalInterest = $principal * $monthlyRate * ($count / 30); // approximate per count

        $total = $principal + $totalInterest;
        $per = round($total / $count, 2);

        for ($i = 1; $i <= $count; $i++) {
            $due = (clone $start)->addMonths($i - 1);
            $principalPortion = round($principal / $count, 2);
            $interestPortion = round(($totalInterest / $count), 2);

            $this->installments()->create([
                'installment_no' => $i,
                'due_date' => $due->toDateString(),
                'principal_amount' => $principalPortion,
                'interest_amount' => $interestPortion,
                'amount' => $principalPortion + $interestPortion,
                'status' => 'pending'
            ]);
        }
    }

    /**
     * Check if all installments are paid and mark loan as completed
     */
    public function checkCompletion()
    {
        $totalInstallments = $this->installments()->count();
        $paidInstallments = $this->installments()->where('status', 'paid')->count();

        if ($totalInstallments > 0 && $totalInstallments === $paidInstallments) {
            $this->status = self::STATUS_COMPLETED;
            $this->save();

            // Notify member about loan completion
            $member = $this->member;
            if ($member) {
                \App\Services\NotificationService::send('loan_completed', [$member->email, $member->phone], ['email', 'sms'], 'Your loan has been fully repaid. Thank you!', ['loan_id' => $this->id]);
            }
        }
    }
}
