<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class LoanCollection extends Model
{
    use Auditable;

    protected $fillable = ['loan_installment_id', 'collector_id', 'amount', 'paid_amount', 'status', 'verified_by', 'verified_at', 'transaction_date', 'remarks'];

    public function installment()
    {
        return $this->belongsTo(LoanInstallment::class, 'loan_installment_id');
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }
}
