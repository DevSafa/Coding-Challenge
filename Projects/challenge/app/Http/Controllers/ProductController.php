<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\ProductCategoryServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
	/**
	 * The productService instance.
	*/
	protected $productService;

	/**
	 * The categoryService instance.
	*/
	protected $categoryService;

	/**
	 * Create a new ProductController instance.
	 *
	 * @param  ProductService  $productService
	 * 
	 * @return void
	*/
	public function __construct(
			ProductServiceInterface $productService , 
			CategoryServiceInterface $categoryService)
	{
		$this->productService = $productService;
		$this->categoryService = $categoryService;

	}

	/**
	 * Call the  @method index in ProductService instance to get all products
	 * 
	 * @return  array
	*/
	public function index() : array
	{
		return $this->productService->index();
	}

	/**
	 * 
	 * validate data using CreateProductRequest 
	 * 
	 * get data for Category and Product services  using CreateProductRequest
	 * 
	 * @param  App\Http\Requests\CreateProductRequest  $request
	 * 
	 * @return  void
	*/
	public function store(CreateProductRequest $request) : Response
	{
		$dataForCategoryService = $request->getDataForCategoryService();
		$dataForProductService = $request->getDataForProductService();

		$categories =  $this->categoryService->getCategories($dataForCategoryService);
		$product = $this->productService->storeProduct($dataForProductService->put('categories',$categories));

		return response($product , 201)
                  ->header('Content-Type', 'application/json');
	}
}
