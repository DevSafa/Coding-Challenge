<?php
namespace App\Http\Controllers;

use App\Repositories\Category\CategoryRepository;


class CategoryController extends Controller
{

    public function getCategories()
    {
        return CategoryRepository::getCategories();
    }

    public function getProductsCategory($id)
    {
        return CategoryRepository::getProductsCategory($id);
    }
}
