<?php

namespace App\Http\Controllers;
use App\Repositories\Category\CategoryRepositoryInterface;
class Category extends Controller
{

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepository = $categoryRepositoryInterface;
    }

    public function categories()
    {
        return $this->categoryRepository->categories();
    }

 
    public function parents()
    {
        return  $this->categoryRepository->parents();
    }


    public function children($id)
    {
        return $this->categoryRepository->children($id);
    }


    public function parent($id)
    {
        return $this->categoryRepository->parent($id);
    }

   
    public function products($id)
    {
        return $this->categoryRepository->products($id);
    }
}
