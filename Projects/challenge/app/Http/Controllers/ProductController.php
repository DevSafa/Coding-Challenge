<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	private $productService;

	public function __contruct(ProductServiceInterface $productService)
	{
		$this->productService = $productService;
	}


}
