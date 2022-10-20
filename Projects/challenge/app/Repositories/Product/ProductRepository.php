<?php
namespace App\Repositories\Product;

use App\Models\Product;

use App\Repositories\Category\CategoryRepositoryInterface;


class ProductRepository implements ProductRepositoryInterface 
{
    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepository = $categoryRepositoryInterface;
    }
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
        $categories = [];
        array_push($categories , $request->category);
      
        $parent = $this->categoryRepository->parent($request->category);
        while(!empty($parent->toArray()))
        {
            array_push($categories , $parent[0]->id);
            $parent = $this->categoryRepository->parent($parent[0]->id);
        }
       
     
        $product->categories()->sync($categories);
        $product->upload($name,$request->file('image'));

    }
}
?>