<?php

namespace App\Providers;

use App\Interfaces\Repositories\CategoryProductRepositoryInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\GetDataServiceInterface;
use App\Interfaces\Services\ProductCreationServiceInterface;
use App\Repositories\CategoryProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Services\GetDataService;
use App\Services\ProductCreationService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            ProductCreationServiceInterface::class,
            ProductCreationService::class
        );
        $this->app->bind(
            GetDataServiceInterface::class,
            GetDataService::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            CategoryProductRepositoryInterface::class,
            CategoryProductRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $categoryRepository = new CategoryRepository();
        // $categories = $categoryRepository->getCategoriesIds();

        // $categories = $categories->toArray();

        // $tmp = array();

        // foreach ($categories as $country)
        // {
        //     $tmp[] = $country['id'];
        // }

        // Config::set('categories', $tmp);
    }
}
