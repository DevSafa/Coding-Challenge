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


	public function uploadProductImage($image)
	{
		$image->storeAs('public/images',$image);
	}


	public function createProduct($request)
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

		$this->attachCategories($product,$request['category']);
		$this->uploadProductImage($request->file('image'));

		return $product;
	}

	public static function getProducts()
	{
		return Product::get();
	}
}

?>