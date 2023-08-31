<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Classwork;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $user=Auth::user();

        // App::setLocale($user->profile->locale);
        Paginator::useBootstrapFive();

        Relation::enforceMorphMap([
            'post' => Post::class,
            'classwork' => Classwork::class,
        ]);
    }
}
