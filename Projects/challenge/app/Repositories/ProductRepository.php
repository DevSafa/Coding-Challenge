<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * get all Products from products table
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection
    {
        return Product::get();
    }

    /**
     * store a product in products table
     *
     * @param   array   $values
     *
     * @return  App\Models\Product
     */
    public function store(array $values): Product
    {
        return Product::create($values);
    }
}
