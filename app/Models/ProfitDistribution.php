<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id', 'amount', 'distribution_date', 'remarks'
    ];

    // Relationship: ProfitDistribution belongs to a Partner
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
