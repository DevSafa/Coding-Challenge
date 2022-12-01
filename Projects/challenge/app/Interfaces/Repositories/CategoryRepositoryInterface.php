<?php

namespace App\Interfaces\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function all(): Collection;
    public function getCategoryById(int $id): ?Category;
    public function getCategories(array $ids): Collection;
}
