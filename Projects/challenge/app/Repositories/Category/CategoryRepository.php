<?php

namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository 
{
	public static function getCategories()
	{
		$categories = Category::whereNull('parent_id')->get();
		return $categories;
	}

	public static function getProductsCategory($id)
	{
		$products = Category::find($id)->products()->get();
		return $products;
	}

	public static function getParent($id)
	{
		return Category::find($id)->parent()->get();
	}
}