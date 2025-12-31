<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Withdrawal extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'member_id',
        'request_date',
        'amount',
        'status',
        'approved_by',
        'approval_date',
        'remarks',
    ];

    // Relationship: Withdrawal belongs to a Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relationship: Withdrawal approved by a User (admin)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
