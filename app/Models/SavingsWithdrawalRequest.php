<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class SavingsWithdrawalRequest extends Model
{
    use Auditable;

    protected $fillable = ['member_id', 'amount', 'status', 'approved_by', 'approved_at'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
