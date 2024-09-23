<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TodoRepositoryInterface;
use App\Repositories\TodoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the interface to the implementation
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
