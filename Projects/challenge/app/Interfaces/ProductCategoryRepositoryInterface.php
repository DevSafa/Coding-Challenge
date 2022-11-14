<?php
namespace App\Interfaces;

use Illuminate\Support\Collection as SupportCollection;

interface ProductCategoryRepositoryInterface 
{
    public function addProductCategory(SupportCollection $values) : void;

}