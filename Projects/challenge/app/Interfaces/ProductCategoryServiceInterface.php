<?php
namespace App\Interfaces;

use Illuminate\Support\Collection as SupportCollection;

interface ProductCategoryServiceInterface 
{
    public function addProductCategory(SupportCollection $values) : void;
}