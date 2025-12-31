<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function($model){
            AuditLog::create([
                'user_id' => auth()->id() ?? null,
                'auditable_type' => get_class($model),
                'auditable_id' => $model->id,
                'action' => 'created',
                'old_values' => null,
                'new_values' => $model->toArray(),
                'ip' => request()->ip() ?? null,
                'user_agent' => request()->userAgent() ?? null,
            ]);
        });

        static::updated(function($model){
            AuditLog::create([
                'user_id' => auth()->id() ?? null,
                'auditable_type' => get_class($model),
                'auditable_id' => $model->id,
                'action' => 'updated',
                'old_values' => $model->getOriginal(),
                'new_values' => $model->getChanges(),
                'ip' => request()->ip() ?? null,
                'user_agent' => request()->userAgent() ?? null,
            ]);
        });

        static::deleted(function($model){
            AuditLog::create([
                'user_id' => auth()->id() ?? null,
                'auditable_type' => get_class($model),
                'auditable_id' => $model->id,
                'action' => 'deleted',
                'old_values' => $model->toArray(),
                'new_values' => null,
                'ip' => request()->ip() ?? null,
                'user_agent' => request()->userAgent() ?? null,
            ]);
        });
    }
}
