<?php
namespace App\Repositories\Product;


interface ProductRepositoryInterface
{
    /** get all Products in database */
    public function products();
    public function create($product);
}

?>