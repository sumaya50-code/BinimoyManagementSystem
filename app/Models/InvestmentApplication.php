<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class InvestmentApplication extends Model {
    use Auditable;

    protected $fillable = [
        'member_id','partner_id','investment_no','application_date','applied_amount',
        'approved_amount','investment_date','business_name','owner_name',
        'trade_license_no','business_address','business_type','status'
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function partner() {
        return $this->belongsTo(Partner::class);
    }
}
