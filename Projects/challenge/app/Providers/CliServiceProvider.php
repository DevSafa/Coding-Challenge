<?php

namespace App\Providers;

use App\Interfaces\CliServiceInterface;
use App\Services\CliService;
use Illuminate\Support\ServiceProvider;

class CliServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CliServiceInterface::class, CliService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}