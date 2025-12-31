<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $fillable = ['code','name','type','parent_id','description','is_active'];

    public function parent() {
        return $this->belongsTo(ChartOfAccount::class,'parent_id');
    }

    public function children() {
        return $this->hasMany(ChartOfAccount::class,'parent_id');
    }
}
