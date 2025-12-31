<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['journal_type','transactionable_id','transactionable_type','narration','created_by','posted_at'];

    public function entries() {
        return $this->hasMany(LedgerEntry::class);
    }

    public function transactionable() {
        return $this->morphTo();
    }
}
