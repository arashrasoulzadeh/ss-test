<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class KavenegarChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        Http::withUrlParameters([
            'endpoint' => 'https://api.kavenegar.com/v1/' . env('KAVEHNEGAR_API_KEY') . '/sms/send.json',
            'receptor' => $notifiable->phone_number,
            'sender' => env('KAVEHNEGAR_SENDER'),
            'message' => $notification->toArray($notifiable)['message'],
        ])->get('{+endpoint}?receptor={receptor}&sender={sender}&message={message}');
    }
}
