<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Auditable;

class SavingsAccount extends Model
{
    use Auditable, HasFactory;

    protected $fillable = ['member_id', 'balance', 'interest_rate', 'account_no'];

    public static function booted()
    {
        static::created(function ($account) {
            // ensure a human-friendly account number exists after creation
            if (empty($account->account_no)) {
                $account->update(['account_no' => 'SA' . str_pad($account->id, 6, '0', STR_PAD_LEFT)]);
            }
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function transactions()
    {
        return $this->hasMany(SavingsTransaction::class);
    }
}
