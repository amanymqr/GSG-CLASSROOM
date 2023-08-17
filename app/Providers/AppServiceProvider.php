<?php

namespace App\Providers;

use App\Models\Classwork;
use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

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

        Paginator::useBootstrapFive();

        Relation::enforceMorphMap([
            'post'=>Post::class,
            'classwork'=>Classwork::class,
        ]);
    }


}
