<?php

namespace App\Services;

use App\Exceptions\InvalidParameterException;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\GetDataServiceInterface;
use App\Models\Category;
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

    protected $categoryProduct = null;
    /**
     * Create a new GetDataService instance
     *
     * @return void
    */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryProductRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->categoryProductRepository = $categoryProductRepository;
    }

    /**
     * get all products using productRepository
     *
     * @return array
     */
    public function getProducts(): array
    {
        return $this->productRepository->all()->toArray();
    }

    /**
     * get all categories using categoryRepository
     *
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categoryRepository->all()->toArray();
    }

    /**
     * get all sub categories of  a category
     * store their product in a collection
     *
     * @param int $id
     *
     * @return array
     */
    public function getProductsByCategory(int $id): array
    {
        $category = $this->categoryRepository->getCategoryById($id);
        if ($category === null) {
            throw new InvalidParameterException("Invalid category Id");
        }
        $ids = $this->getIds($category);
        $categories = $this->categoryRepository->getCategories($ids);

        return $this->productsOfCategory($categories);
    }

    /**
     * get products from a given collection of categories
     *
     * @return array
     */
    protected function productsOfCategory(Collection $categories): array
    {
        $products = collect();
        foreach ($categories as $category) {
            $categoryProducts = $category->products()->get();
            $products = $products->merge($categoryProducts);
        }
        return $products->toArray();
    }


    /**
     * get Ids of children recursively
     *
     * @param
     */
    protected function getIds(Category $category): array
    {
        $categoriesIds = $this->collectIds($category);
        return $categoriesIds;
    }

    /**
     * get children ids of a given category
     *
     * @param Category
     *
     * @return array
     */
    protected function collectIds(Category $topLevelCategory): array
    {
        $ids = collect();
        $ids = $ids->merge($topLevelCategory['id']);
        $children = $topLevelCategory['children'];
        if ($children) {
            foreach ($children as $category) {
                $ids = $ids->merge($this->collectIds($category));
            }
        }
        return ($ids->toArray());
    }
}
