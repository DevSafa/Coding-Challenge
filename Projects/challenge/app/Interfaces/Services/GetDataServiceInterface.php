<?php

namespace App\Interfaces\Services;

interface GetDataServiceInterface
{
    public function getProducts(): array;
    public function getCategories(): array;
    public function getProductsByCategory(int $id): array;
}
