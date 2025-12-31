<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_asset_id',
        'type',
        'amount',
        'description',
        'transaction_date',
        'created_by',
    ];

    // Relationship: Transaction belongs to CashAsset
    public function cashAsset()
    {
        return $this->belongsTo(CashAsset::class, 'cash_asset_id');
    }

    // Relationship: Transaction created by User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
