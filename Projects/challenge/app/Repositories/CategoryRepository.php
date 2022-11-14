<?php
namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection AS EloquentCollection;

class CategoryRepository implements CategoryRepositoryInterface {

    /**
     * get all parent categories  from database  and their children categories
     * 
     *  @return Illuminate\Database\Eloquent\Collection
     */
	public function index() : EloquentCollection
    {
        return Category::whereNull('parent_id')->get();
    }

    public function getCategoryId(string $name) : int
    {
        return Category::where('name',$name)->get()[0]['id'];
    }
}

