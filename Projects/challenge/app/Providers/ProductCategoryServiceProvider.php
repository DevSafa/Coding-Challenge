<?php

namespace App\Providers;

use App\Interfaces\ProductCategoryRepositoryInterface;
use App\Interfaces\ProductCategoryServiceInterface;
use App\Repositories\ProductCategoryRepository;
use App\Services\ProductCategoryService;
use Illuminate\Support\ServiceProvider;

class ProductCategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductCategoryServiceInterface::class, ProductCategoryService::class);
        $this->app->bind(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);
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
