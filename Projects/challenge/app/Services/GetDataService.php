<?php

namespace App\Services;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\GetDataServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class GetDataService implements GetDataServiceInterface
{
    /**
     * @var App\Interfaces\Repositories\CategoryRepositoryInterface
     */
    protected $categoryRepository = null;

    /**
     * @var App\Interfaces\Repositories\ProductRepositoryInterface;
     */
    protected $productRepository = null;
    
    /**
     * Create a new GetDataService instance
     *
     * @return void
    */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * get all products using productRepository
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getProducts(): Collection
    {
        return $this->productRepository->all();
    }

    /**
     * get all categories using categoryRepository
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getCategories(): Collection
    {
        return $this->categoryRepository->all();
    }

    /**
     * get all categories using categoryRepository
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getProductsByCategory(int $id): Collection
    {
        return $this->categoryRepository->filter($id);
    }
}
