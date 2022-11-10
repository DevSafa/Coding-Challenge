<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Interfaces\ProductServiceInterface;


class ProductController extends Controller
{
	/**
	 * The productService instance.
	*/
	protected $productService;

	/**
	 * Create a new ProductController instance.
	 *
	 * @param  ProductService  $productService
	 * 
	 * @return void
	*/
	public function __construct(ProductServiceInterface $productService)
	{
		$this->productService = $productService;
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
	 * call the @method store  in ProductService instance
	 *
	 * @param  App\Http\Requests\CreateProductRequest  $request
	 * 
	 * @return  void
	*/
	public function store(CreateProductRequest $request) : void
	{
		
		$collection = collect($request->validated());
		$this->productService->store($collection);
	}
}
