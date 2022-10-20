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

    public function store($request)
    {
        $name =  uniqid() . '-' .$request->name . '.' . $request->file('image')->extension();
        $product = Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "image" => $name
        ]);

        $product->upload($name,$request->file('image'));

    }
}
?>