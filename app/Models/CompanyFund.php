<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class CompanyFund extends Model
{
    use Auditable;

    protected $fillable = ['balance'];
}
