<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_installment_id',
        'collected_by',
        'amount_collected',
        'collection_date',
        'payment_method',
        'remarks',
    ];

    // Relationship: Collection belongs to a loan installment
    public function installment()
    {
        return $this->belongsTo(LoanInstallment::class, 'loan_installment_id');
    }

    // Relationship: Collection belongs to a user (collector)
    public function collector()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }
}
