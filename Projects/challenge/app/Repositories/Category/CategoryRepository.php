<?php
namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository 
{
	public static function getCategories()
	{
		$categories = Category::get();
		$parentCategories = $categories->whereNull('parent_id');
		self::binChildren($parentCategories);
		return $parentCategories;

	}
	
	private static function binChildren($categories)
	{
		foreach ($categories as $category)
		{
			$category->children = $category->children()->get();
			if ($category->children->isNotEmpty()) 
			{
				self::binChildren($category->children);
			}
		}
	}

	public static function getProductsCategory($id)
	{
		return Category::find($id)->products()->get();
	}

	public static function getParent($id)
	{
		return Category::find($id)->parent()->get();
	}


}

?>