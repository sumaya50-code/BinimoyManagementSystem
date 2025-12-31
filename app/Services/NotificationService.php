<?php

namespace App\Services;

use App\Models\NotificationLog;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function send(string $type, $to, array $channels, string $body, array $meta = [])
    {
        $log = NotificationLog::create([
            'type' => $type,
            'channels' => $channels,
            'to' => is_array($to) ? json_encode($to) : $to,
            'body' => $body,
            'status' => 'pending',
            'meta' => $meta,
        ]);

        $status = 'sent';
        try {
            if (in_array('email', $channels) && is_string($to) && filter_var($to, FILTER_VALIDATE_EMAIL)) {
                Mail::raw($body, function($message) use ($to, $type){
                    $message->to($to);
                    $message->subject('Notification: '.$type);
                });
            }

            if (in_array('sms', $channels)) {
                // Placeholder: integrate SMS provider (Twilio, Nexmo) here. For now, log to laravel log.
                logger()->info('SMS to '.json_encode($to).': '.$body);
            }

        } catch (\Exception $e) {
            $status = 'failed';
            logger()->error('Notification send failed: '.$e->getMessage());
        }

        $log->update(['status' => $status, 'sent_at' => now()]);

        return $log;
    }
}
