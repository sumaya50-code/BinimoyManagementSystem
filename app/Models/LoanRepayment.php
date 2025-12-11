<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id', 'installment_number', 'principal_amount',
        'interest_amount', 'total_amount', 'late_fee',
        'due_date', 'paid_at', 'status'
    ];

    public function loan() {
        return $this->belongsTo(Loan::class);
    }
}
