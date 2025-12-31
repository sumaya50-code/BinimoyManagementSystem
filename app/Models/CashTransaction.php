<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class CashTransaction extends Model
{
    use Auditable;

    protected $fillable = ['cash_asset_id','type','amount','reference_type','reference_id','remarks'];

    public function cashAsset() {
        return $this->belongsTo(CashAsset::class);
    }

    protected static function booted()
    {
        static::created(function($txn){
            try {
                \App\Services\LedgerService::postCashTransaction($txn, auth()->id() ?? null);
            } catch (\Exception $e) {
                logger()->error('Ledger post error for cash txn '.$txn->id.': '.$e->getMessage());
            }
        });
    }
}
