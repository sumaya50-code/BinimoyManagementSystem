<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanGuarantor extends Model
{
    protected $fillable = [
        'loan_proposal_id',
        'name',
        'father_name',
        'mother_name',
        'nationality',
        'relationship',
        'present_address',
        'permanent_address',
        'mobile_no',
        'email',
        'profession',
        'nid_number',
        'liabilities',
        'assets',
        'declaration',
        'guarantor_signature',
        'tip_sign',
        'employee_signature',
        'manager_signature',
        'authorized_person_name',
        'authorized_person_signature',
        'investment_received',
        'investment_amount_words'
    ];

    public function loanProposal()
    {
        return $this->belongsTo(LoanProposal::class);
    }
}
