<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\Category;

class ProductRepository implements ProductRepositoryInterface 
{

    /** get all Products in database */
    public function products()
    {
        return Product::get();
    }

    public function store($request)
    {
        $name =  uniqid() . '-' .$request->name . '.' . $request->file('image')->extension();
        $product = Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "image" => $name,
        ]);
        $product->categories()->sync($request->category);
        /* to do : must add also the product to teh parent category if exist */
      
        $product->upload($name,$request->file('image'));

    }
}
?>