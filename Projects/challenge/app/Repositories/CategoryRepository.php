<?php
namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface {

	public function index() : array
    {
        return Category::whereNull('parent_id')->get()->toArray();
    }
}

