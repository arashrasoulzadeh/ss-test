<?php

namespace app\Channels;

use Illuminate\Notifications\Notification;

class KavenegarChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
    }
}
