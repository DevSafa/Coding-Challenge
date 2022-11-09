<?php
namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {
    
    public function injectionTest()
    {
        return "hello from Injection dependency";
    }
}