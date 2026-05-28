<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\ReportRepositoryInterface::class,
            \App\Repositories\ReportRepository::class
        );
        $this->app->bind(
            \App\Contracts\VictimNeedRepositoryInterface::class,
            \App\Repositories\VictimNeedRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
