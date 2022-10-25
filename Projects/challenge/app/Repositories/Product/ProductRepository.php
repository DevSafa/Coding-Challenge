<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Category\CategoryRepository;


class ProductRepository
{
	private static function attachCategories($product,$category)
	{
		$categories = [];
		array_push($categories , $category);
		$parent = CategoryRepository::getParent($category); 
		while (!empty($parent->toArray()) )
		{
			array_push($categories, $parent[0]->id);
			$parent = CategoryRepository::getParent($parent[0]->id);
		} 
		$product->categories()->sync($categories);
	}


	private static  function uploadProductImage($image,$name)
	{
		$image->storeAs('public/images',$name);
	
	}


	public static  function createProduct($request)
	{
		$name =  uniqid() . '-' .$request->name . '.' . $request->file('image')->extension();
		
		$product = Product::create(
			[
				"name" => $request['name'],
				"description" => $request['description'],
				"price" => (float)$request['price'],
				"image" => $name,
			]
		);
		
		self::attachCategories($product,$request['category']);
		$request->file('image')->storeAs('public/images',$name);
		self::uploadProductImage($request->file('image'),$name);

		return $product;
	}

	public static function getProducts()
	{
		return Product::get();
	}
}

?>