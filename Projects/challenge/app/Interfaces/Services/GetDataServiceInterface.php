<?php

namespace App\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface GetDataServiceInterface
{
    public function getProducts(): Collection;
    public function getCategories(): Collection;
    public function getProductsByCategory(int $id): Collection;
}
