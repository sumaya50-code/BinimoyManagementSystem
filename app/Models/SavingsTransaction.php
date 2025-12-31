<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class SavingsTransaction extends Model
{
    use Auditable;

    protected $fillable = ['savings_account_id', 'type', 'amount', 'remarks', 'status', 'transaction_date'];

    public function account()
    {
        return $this->belongsTo(SavingsAccount::class, 'savings_account_id');
    }

    protected static function booted()
    {
        static::updated(function ($txn) {
            // when txn becomes approved, post ledger entries (idempotent)
            if ($txn->status === 'approved') {
                try {
                    \App\Services\LedgerService::postSavingsTransaction($txn, auth()->id() ?? null);

                    // Create cash transaction and update cash asset
                    $cashAsset = \App\Models\CashAsset::first();
                    if ($cashAsset) {
                        if ($txn->type === 'deposit') {
                            \App\Models\CashTransaction::create([
                                'cash_asset_id' => $cashAsset->id,
                                'type' => 'inflow',
                                'amount' => $txn->amount,
                                'reference_type' => 'savings_deposit',
                                'reference_id' => $txn->id,
                                'remarks' => 'Savings deposit approved'
                            ]);
                            $cashAsset->increment('balance', $txn->amount);
                        } elseif ($txn->type === 'withdrawal') {
                            \App\Models\CashTransaction::create([
                                'cash_asset_id' => $cashAsset->id,
                                'type' => 'outflow',
                                'amount' => $txn->amount,
                                'reference_type' => 'savings_withdrawal',
                                'reference_id' => $txn->id,
                                'remarks' => 'Savings withdrawal approved'
                            ]);
                            $cashAsset->decrement('balance', $txn->amount);
                        }
                    }
                } catch (\Exception $e) {
                    // log but don't break
                    logger()->error('Ledger post error for savings txn ' . $txn->id . ': ' . $e->getMessage());
                }
            }
        });
    }
}
