<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class GhasedakChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        Http::withHeaders([
            'apikey' => env('GHASEDAK_API_KEY')
        ])->post('http://api.iransmsservice.com/v2/sms/send/simple', [
            'message' => $notification->toArray($notifiable)['message'],
            'sender' => env('GHASEDAK_SENDER'),
            'receptor' => $notifiable->phone_number,
        ]);
    }
}
