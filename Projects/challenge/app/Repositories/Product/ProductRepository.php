<?php
namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface 
{

    /** get all Products in database */
    public function products()
    {
        return Product::get();
    }

    public function create($product)
    {
        return "hello";
    }

 
}
?>