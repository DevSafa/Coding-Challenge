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
        return $product->get_image();
    //   return [
    //         $product->get_name(),
    //         $product->get_description(),
    //         $product->get_price(),
    //         $product->get_category(),
    //         $product->get_image()
    //     ];
    }

 
}
?>