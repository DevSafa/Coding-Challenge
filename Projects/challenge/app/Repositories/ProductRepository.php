<?php
namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;

class ProductRepository implements ProductRepositoryInterface 
{
    /**
     * get all products  from database 
     * @return EloquentCollection
     */
    public function index(): EloquentCollection
    {
        return Product::get();
    }

    /**
     * store product in database .
     * attach categories to product  using eloquent relation.
     * 
     * @param SupportCollection  $values
     * @param array  $categories
     * @return array 
     */
	public function storeProduct(
        SupportCollection $values, 
        array $categories
    ): array
    {
            $product = Product::create($values->toArray());
            $product->categories()->sync($categories);
            return $product->toArray();
    }
}