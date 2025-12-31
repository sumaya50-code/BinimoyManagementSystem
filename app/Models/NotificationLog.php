<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $fillable = ['type','channels','to','body','status','sent_at','meta'];

    protected $casts = [
        'channels' => 'array',
        'meta' => 'array',
        'sent_at' => 'datetime',
    ];
}
