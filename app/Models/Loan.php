<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'member_id',
        'loan_amount',
        'interest_rate',
        'installment_count',
        'installment_type',
        'disbursement_date',
        'status',
        'remarks'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
