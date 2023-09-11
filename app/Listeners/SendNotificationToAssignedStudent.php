<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\ClassworkCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewClassworkNotification;

class SendNotificationToAssignedStudent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassworkCreated $event): void
    {
        //عشان نبعت بس لواحد
        // $user = User::find(1);
        // $user->notify(new NewClassworkNotification($event->classwork));

        // //لكل ال يوزرز
        // foreach($event->classwork->users as $user)
        // {
        //     $user->notify(new NewClassworkNotification($event->classwork));
        // }

        //باستخدام ال notification
        Notification::send($event->classwork->users, new NewClassworkNotification($event->classwork));
    }
}
