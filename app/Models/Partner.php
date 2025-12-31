<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = ['name', 'share_percentage', 'invested_amount', 'status', 'total_profits'];

    public function investments()
    {
        return $this->hasMany(InvestmentApplication::class);
    }
}
