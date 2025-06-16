<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Theater;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // View Composer for visitor navigation bar
        View::composer('layouts.visetor_sit_nav', function ($view) {
            $theaters = Theater::all();
            $view->with('theaters', $theaters);
        });
    }
}
