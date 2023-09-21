<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\ClassworkCreated;
use App\Jobs\SendClassroomNotification;
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
        // dd($event);
        //عشان نبعت بس لواحد
        // $user = User::find(1);
        // $user->notify(new NewClassworkNotification($event->classwork));

        // //لكل ال يوزرز
        // foreach($event->classwork->users as $user)
        // {
        //     $user->notify(new NewClassworkNotification($event->classwork));
        // }

        //باستخدام ال notification
        $classwork = $event->classwork;
        // Notification::send($classwork->users, new NewClassworkNotification($event->classwork));
        $job =
            new SendClassroomNotification($classwork->users, new NewClassworkNotification($classwork));

        $job->onQueue('y');
        dispatch($job)->onQueue('z');
        // SendClassroomNotification::dispatch($classwork->users, new NewClassworkNotification($classwork));
    }
}
