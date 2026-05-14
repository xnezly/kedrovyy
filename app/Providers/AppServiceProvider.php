<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application service.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application service.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
    }
}
