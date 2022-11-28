<?php

namespace App\Interfaces\Repositories;

interface CategoryProductRepositoryInterface
{
    public function store(array $values): bool;
}
