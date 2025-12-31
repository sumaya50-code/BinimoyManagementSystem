<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Auditable;

class LoanInstallment extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['loan_id', 'installment_no', 'due_date', 'principal_amount', 'interest_amount', 'amount', 'paid_amount', 'penalty_amount', 'status', 'paid_at'];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function collections()
    {
        return $this->hasMany(LoanCollection::class);
    }

    /**
     * Calculate and apply penalty for overdue installment
     */
    public function applyPenalty()
    {
        if ($this->status === 'paid' || $this->due_date >= now()->toDateString()) {
            return false; // Not overdue or already paid
        }

        $overdueDays = now()->diffInDays(\Carbon\Carbon::parse($this->due_date));

        // Get penalty rate from loan (default 2% per day if not set)
        $penaltyRate = $this->loan->penalty_rate ?? 2; // 2% per day

        $penalty = ($this->amount * $penaltyRate / 100) * $overdueDays;

        $this->penalty_amount = $penalty;
        $this->save();

        return $penalty;
    }

    /**
     * Collect payment for this installment
     */
    public function collect($amount, $collectorId = null, $transactionDate = null, $remarks = null)
    {
        $this->paid_amount += $amount;
        if ($this->paid_amount >= $this->amount + $this->penalty_amount) {
            $this->status = 'paid';
            $this->paid_at = now();
        }

        $this->save();

        // Create collection record
        $this->collections()->create([
            'collector_id' => $collectorId,
            'amount' => $amount,
            'status' => 'collected',
            'transaction_date' => $transactionDate ?? now()->toDateString(),
            'remarks' => $remarks
        ]);

        // Check if loan is completed
        $this->loan->checkCompletion();

        return true;
    }
}
