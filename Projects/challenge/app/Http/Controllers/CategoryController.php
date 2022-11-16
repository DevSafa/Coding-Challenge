<?php
namespace App\Http\Controllers;

use App\Interfaces\CategoryServiceInterface;

class CategoryController extends Controller
{
    /**
     * The category service instance
     * @var CategoryServiceInterface
    */
    protected $categoryService = null;

    /**
     * Create a new CategoryController instance
     * @param  CategoryServiceInterface  $categoryService
     * @return void
    */
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * call the category service instance to get all categories
     * @return  array
    */
    public function index(): array
    {
        return $this->categoryService->index();
    }

    /**
     *call the category service instance to get products by category
     * @param  int $id
     * @return array
     */
    public function getProducts(int $id): array
    {
        return $this->categoryService->getProducts($id);
    }
}
