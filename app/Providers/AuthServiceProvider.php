<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Classroom;
use App\Models\Classwork;
use App\Models\Scopes\UserClassroomScope;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Define Gates

        Gate::before(function (User $user, $abitiy) {
            if ($user->super_admin) {
                return true;
            }
        });



        Gate::define('classworks.view', function (User $user, Classwork $classwork) {
            $teacher = $user->classrooms()->wherePivot('classroom_id', '=', $classwork->classroom_id)
                ->wherePivot('role', '=', 'teacher')->exists();

            $assigned = $user->classworks()->wherePivot('classwork_id', '=', $classwork->id)->exists();
            return ($teacher || $assigned);
        });




        Gate::define('classworks.create', function (User $user, Classroom $classroom) {

            $result = $user->classrooms()
                ->withoutGlobalScope(UserClassroomScope::class)
                ->wherePivot('classroom_id', '=', $classroom->id)
                ->wherePivot('role', '=', 'teacher')->exists();


            return $result
                ? Response::allow()
                : Response::deny('You are not teacher in this classwork');
        });


        Gate::define('classworks.update', function (User $user, Classwork $classwork) {
            return $classwork->user_id == $user->id && $user->classrooms()->wherePivot('classroom_id', '=', $classwork->classroom_id)
                ->wherePivot('role', '=', 'teacher')->exists();
        });





        Gate::define('classworks.delete', function (User $user, Classwork $classwork) {
            return  $classwork->user_id == $user->id && $user->classrooms()->wherePivot('classroom_id', '=', $classwork->classroom_id)
                ->wherePivot('role', '=', 'teacher')->exists();
        });

        Gate::define('submissions.create', function (User $user, ClassWork $classWork) {
            $teacher =  $user->classrooms()
                ->wherePivot('classroom_id', '=', $classWork->classroom_id)
                ->wherePivot('role', '=', 'teacher')->exists();

            if ($teacher) {
                return false;
            }
            return $user->classworks()
                ->withPivot('classwork_id', '=', $classWork->id)
                ->exists();
        });
    }
}
