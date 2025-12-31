<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class LoanProposal extends Model
{
    use Auditable;

    protected $fillable = ['member_id', 'proposed_amount', 'approved_amount', 'status', 'business_type', 'loan_proposal_date', 'savings_balance', 'dps_balance', 'approved_amount_audit', 'approved_amount_manager', 'approved_amount_area', 'auditor_signature', 'manager_signature', 'area_manager_signature', 'date_approved', 'applicant_signature', 'employee_signature', 'audited_verified', 'verified_by_manager', 'verified_by_area_manager', 'authorized_signatory_signature'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function guarantors()
    {
        return $this->hasMany(LoanGuarantor::class);
    }

    public function loan()
    {
        return $this->hasOne(Loan::class);
    }

    // Approval workflow methods
    public function submitForAudit()
    {
        if ($this->status !== 'pending') return false;
        $this->status = 'under_audit';
        $this->submitted_at = now();
        $this->save();
        return true;
    }

    public function approveAudit()
    {
        if ($this->status !== 'under_audit') return false;
        $this->status = 'manager_review';
        $this->audited_at = now();
        $this->save();
        return true;
    }

    public function rejectAudit($reason = null)
    {
        if ($this->status !== 'under_audit') return false;
        $this->status = 'rejected';
        $this->save();
        return true;
    }

    public function submitForManagerReview()
    {
        if ($this->status !== 'manager_review') return false;
        $this->status = 'area_manager_approval';
        $this->save();
        return true;
    }

    public function approveManagerReview($approvedAmount = null)
    {
        if ($this->status !== 'manager_review') return false;
        $this->status = 'area_manager_approval';
        if ($approvedAmount) {
            $this->approved_amount_manager = $approvedAmount;
        }
        $this->manager_approved_at = now();
        $this->save();
        return true;
    }

    public function rejectManagerReview($reason = null)
    {
        if ($this->status !== 'manager_review') return false;
        $this->status = 'rejected';
        $this->save();
        return true;
    }

    public function approveAreaManager()
    {
        if ($this->status !== 'area_manager_approval') return false;
        $this->status = 'approved';
        $this->save();
        return true;
    }

    public function rejectAreaManager($reason = null)
    {
        if ($this->status !== 'area_manager_approval') return false;
        $this->status = 'rejected';
        $this->save();
        return true;
    }
}
