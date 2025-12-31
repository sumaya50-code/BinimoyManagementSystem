<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'account_name',
        'account_number',
        'balance',
        'details',
    ];

    // Relationship: CashAsset has many cash transactions
    public function transactions()
    {
        return $this->hasMany(CashTransaction::class);
    }
}
