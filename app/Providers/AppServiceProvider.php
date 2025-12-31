<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Models\AuditLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, function(Login $event){
            try {
                AuditLog::create([
                    'user_id' => $event->user->id,
                    'action' => 'login',
                    'ip' => request()->ip() ?? null,
                    'user_agent' => request()->userAgent() ?? null,
                ]);
            } catch (\Exception $e) {
                logger()->error('Audit log failed for login: '.$e->getMessage());
            }
        });
    }
}
