<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $fillable = [
        'member_id',
        'balance',
        'interest_rate',
        'type',
        'amount',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
