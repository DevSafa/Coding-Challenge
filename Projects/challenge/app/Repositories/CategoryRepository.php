<?php
namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection AS EloquentCollection;

class CategoryRepository implements CategoryRepositoryInterface 
{
    /**
     * get all parent categories  from database  and their children categories
     *  @return EloquentCollection
     */
    public function index(): EloquentCollection
    {
        return Category::whereNull('parent_id')->get();
    }

    /**
     * get category with specific name
     * @param string $name
     * @return int
     */
    public function getCategoryId(string $name): int
    {
        return Category::where('name',$name)->get()[0]['id'];
    }

    /**
     * get parent of a category
     * @param int $id
     * @return EloquentCollection
     */
    public function getParent(int $id): EloquentCollection
    {
        return Category::find($id)->parent()->get();
    }

    /**
     * get products of a category
     * @param int $id
     * @return EloquentCollection
     */
    public function getProducts(int $id): EloquentCollection
    {
        $products = Category::find($id)->products()->get();
        return $products;
    }
}
