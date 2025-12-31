<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreviousLoan extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_proposal_id',
        'installment_no',
        'loan_amount',
        'disbursement_date',
        'repayment_date',
        'probable_repayment_date',
        'loan_status'
    ];
}
