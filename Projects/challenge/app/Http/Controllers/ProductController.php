<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\ProductCategoryServiceInterface;


class ProductController extends Controller
{
	/**
	 * The productService instance.
	*/
	protected $productService;

	/**
	 * The productService instance.
	*/
	protected $categoryService;

	/**
	 * The ProductCategoryService instance.
	*/
	protected $ProductCategoryService;

	/**
	 * Create a new ProductController instance.
	 *
	 * @param  ProductService  $productService
	 * 
	 * @return void
	*/
	public function __construct(
			ProductServiceInterface $productService , 
			ProductCategoryServiceInterface $ProductCategoryService,
			CategoryServiceInterface $categoryService)
	{
		$this->productService = $productService;
		$this->categoryService = $categoryService;
		$this->ProductCategoryService = $ProductCategoryService;

	}

	/**
	 * Call the  @method index in ProductService instance 
	 *
	 * @return  array
	*/
	public function index() : array
	{
		return $this->productService->index()->toArray();
	}

	/**
	 * 
	 * validate data.
	 * 
	 * call Product service to store Product data  and get id of the product
	 * 
	 * call Category service to get Id of category from it's name
	 * 
	 * call ProductCategory to store many to many relationship 
	 *
	 * @param  App\Http\Requests\CreateProductRequest  $request
	 * 
	 * @return  void
	*/
	public function store(CreateProductRequest $request) : void
	{
		$dataForProductService = $request->getDataForProductService();
		$product_id = $this->productService->storeProduct($dataForProductService);

		$dataForCategoryService = $request->getDataForCategoryService();
		$category_id =  $this->categoryService->getCategoryId($dataForCategoryService);

		$this->ProductCategoryService->AddProductCategory(collect([
			"product_id" => $product_id,
			"category_id" => $category_id
		]));
	}
}
