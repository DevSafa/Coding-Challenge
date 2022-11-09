<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductServiceInterface;


class ProductController extends Controller
{
	private $productService;

	public function __construct(ProductServiceInterface $productService)
	{
		$this->productService = $productService;
	}

}
