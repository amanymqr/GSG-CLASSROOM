<?php

namespace App\Notifications\Channels;
use App\Services\HadaraSms;
use Illuminate\Notifications\Notification;

class HadaraSMSChannel
{
    public function send(Object $notifiable, Notification $notification): void
    {
        $service = new HadaraSms(config('services.hadara.key'));

        $service->send(
            $notifiable->routeNotificationForHadara($notification),
            $notification->toHadara($notifiable),
        );
    }
}
