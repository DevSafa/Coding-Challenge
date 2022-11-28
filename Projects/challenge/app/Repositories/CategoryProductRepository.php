<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryProductRepositoryInterface;
use App\Models\CategoryProduct;

class CategoryProductRepository implements CategoryProductRepositoryInterface
{
    /**
     * store many to many relationship
     * between product and category
     * in category-product table
     *
     * @param array $values
     *
     * @return  bool
     */
    public function store(array $values): bool
    {
        return CategoryProduct::insert($values);
    }
}
