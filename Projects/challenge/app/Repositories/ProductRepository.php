<?php
namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;

class ProductRepository implements ProductRepositoryInterface {

    /**
     * get all products  from database 
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index() : EloquentCollection
    {
        return Product::get();
    }

    /**
     * store product in database .
     * attach categories to product .
     * 
     * @param Illuminate\Support\Collection  $values
     */
	public function storeProduct(SupportCollection $values, array $categories) : void 
    {
            $product = Product::create($values->toArray());
            $product->categories()->sync($categories);
    }
}