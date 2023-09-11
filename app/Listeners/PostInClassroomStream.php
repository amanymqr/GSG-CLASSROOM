<?php

namespace App\Listeners;

use App\Events\ClassworkCreated;
use App\Models\Stream;
use Illuminate\Support\Str;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostInClassroomStream
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

        $classwork = $event->classwork;
        $content = __(':name posted a new :type: :title',[
            'name' => $classwork->user->name,
            'type' => $classwork->type->value,
            'title' => $classwork->title,
        ]);

        Stream::create([
            // 'id' => Str::uuid(),//عرفناه boot للمودل
            'classroom_id' => $classwork->classroom_id,
            'user_id' => $classwork->user_id,
            'content' => $content,
            'link' => route('classroom.classwork.show',[
                'classroom' => $classwork->classroom_id,
                'classwork' => $classwork->id,

            ]),
        ]);
    }
}
