<?php

namespace App\Interfaces\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function all(): Collection;
    public function filter(int $id): Collection;
    public function getCategoryByName(string $name): Category;
}
