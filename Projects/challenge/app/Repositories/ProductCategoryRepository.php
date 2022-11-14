<?php
namespace App\Repositories;

use App\Interfaces\ProductCategoryRepositoryInterface;
use App\Models\ProductCategory;
use Illuminate\Support\Collection as SupportCollection;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface {

    /**
	 * create a many to many relationship in database layer 
	 *
	 * @param  use Illuminate\Support\Collection  $values
	 * 
	 * @return void
	*/
    public function addProductCategory(SupportCollection $values) : void
    {
        ProductCategory::create($values->toArray());
    }
}