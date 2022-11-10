<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Interfaces\ProductServiceInterface;


class ProductController extends Controller
{
	private $productService;

	public function __construct(ProductServiceInterface $productService)
	{
		$this->productService = $productService;
	}

	public function store(CreateProductRequest $request)
	{
		return "no errors in validation";
	}

}
