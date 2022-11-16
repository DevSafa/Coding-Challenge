<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\CategoryServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * The product service instance
     * @var ProductServiceInterface
    */
    protected $productService = null;

    /**
     * The category service instance
     * @var CategoryServiceInterface
    */
    protected $categoryService = null;

    /**
     * Create a new ProductController instance
     * @param  ProductServiceInterface  $productService
     * @param  CategoryServiceInterface $categoryService
     * @return void
    */
    public function __construct(
        ProductServiceInterface $productService, 
        CategoryServiceInterface $categoryService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * Call the product ervice  instance to get all products
     * @return  array
    */
    public function index(): array
    {
        return $this->productService->index();
    }

    /**
     * validate data using CreateProductRequest
     * prepare data for product, category  services using CreateProductRequest
     * @param CreateProductRequest  $request
     * @return  void
    */
    public function store(CreateProductRequest $request): Response
    {
        $dataForCategoryService = $request->getDataForCategoryService();
        $dataForProductService = $request->getDataForProductService();
        
        $categories = $this->categoryService->getCategories(
            $dataForCategoryService
        );
        $product = $this->productService->storeProduct(
            $dataForProductService->put('categories', $categories)
        );
        
        return response($product , 201)
            ->header('Content-Type', 'application/json');
    }
}
