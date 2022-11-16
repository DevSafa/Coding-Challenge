<?php
namespace App\Interfaces;

use Illuminate\Support\Collection as SupportCollection;

interface ProductServiceInterface 
{
    public function index(): array;
    public function storeProduct(SupportCollection $values): array;
}
