<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

	public function getProducts()
	{        
		return ProductRepository::getProducts();
	}

	public function createProduct(Request $request)
	{
		$validator = Validator::make($request->all(),
			[
				'name'			=> 'required|string|unique:products',
				'description'	=> 'required|string|max:1000',
				'price'			=> 'required|numeric',
				'category'		=> 'required|exists:categories,id',
				'image'			=> 'required|image|unique:products'
			]);
	
		if ($validator->fails())
			return response($validator->errors()->toArray(),400);
		else
			return response(ProductRepository::createProduct($request),201);
	}

}
