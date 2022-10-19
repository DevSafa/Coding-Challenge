<?php

namespace App\Http\Controllers;
use App\Repositories\Category\CategoryRepositoryInterface;
class Category extends Controller
{
    /** define constructor to inject CategoryRepository interface in Category Controller */
    /** need to add CategoryRepository interface as provider */
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


    public function childs($id)
    {
        return $this->categoryRepository->childs($id);
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
