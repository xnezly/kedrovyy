<?php

namespace App\Providers;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        View::composer('admin-theme', function ($view): void {
            $view->with('adminPendingApplicationsCount', Application::query()
                ->where('status', ApplicationStatusEnum::PENDING->value)
                ->count());
        });
    }
}
