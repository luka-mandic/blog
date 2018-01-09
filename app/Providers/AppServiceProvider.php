<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Allows every view that implements the sidebar to have the needed variables: archives and tags
        view()->composer('layouts.sidebar', function($view){
            $view->with('archives', \App\Post::archives());
            $view->with('tags', \App\Tag::has('posts')->orderBy('name', 'asc')->pluck('name'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
