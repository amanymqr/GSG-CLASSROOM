<?php

namespace App\Providers;

use App\Listeners\PostInClassroomStream;
use App\Models\Classroom;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */


    //to define observers
    // protected $observers = [
    //     Classroom::class => [ClassroomObserver::class],
    // ];
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ClassworkCreated::class => [
            PostInClassroomStream::class,

        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {

        // Event::listen('classwork.created', function ($classroom, $classwork) {
        //     dd('event triggeres');
        // });
        Event::listen('classwork.created', [new PostInClassroomStream, 'handle']);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
