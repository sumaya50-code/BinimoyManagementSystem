<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class Member extends Model
{
    use HasFactory, Auditable;
    protected $fillable = [
        'member_no',
        'name',
        'guardian_name',
        'nid',
        'phone',
        'email',
        'present_address',
        'permanent_address',
        'nominee_name',
        'nominee_relation',
        'status',
        'gender',
        'dob',
        'marital_status',
        'education',
        'dependents'
    ];

    public function savingsAccounts()
    {
        return $this->hasMany(SavingsAccount::class);
    }

    public function loanProposals()
    {
        return $this->hasMany(LoanProposal::class);
    }

    public function investmentApplications()
    {
        return $this->hasMany(InvestmentApplication::class);
    }

    /**
     * Relationship: Member has many Withdrawals (general withdrawals)
     */
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    /**
     * Relationship: Member has many Savings Withdrawal Requests
     */
    public function savingsWithdrawalRequests()
    {
        return $this->hasMany(SavingsWithdrawalRequest::class, 'member_id');
    }
}
