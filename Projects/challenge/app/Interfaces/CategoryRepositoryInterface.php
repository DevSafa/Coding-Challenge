<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface CategoryRepositoryInterface 
{
    public function index(): EloquentCollection;
    public function getCategoryId(string $name): int;
    public function getParent(int $id): EloquentCollection;
    public function getProducts(int $id): EloquentCollection;
}
