<?php

namespace App\Providers;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\CompletedTaskServiceInterface;
use App\Services\AuthService;
use App\Services\CompletedTaskService;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CompletedTaskServiceInterface::class, CompletedTaskService::class);
        $this->app->singleton(AuthServiceContract::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('ru');
        Paginator::useTailwind();
    }
}
