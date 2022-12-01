<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * get all categories from categories table
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection
    {
        return Category::whereNull('parent_id')
                ->get();
    }

    /**
     * @param  int $id
     *
     * @return App\Models\Category or null
     */
    public function getCategoryById(int $id): ?Category
    {
        return Category::where('id', $id)->first();
    }

    /**
     * @param  string name
     *
     * @return App\Models\Category
     */
    public function getCategoryByName(string $name): Category
    {
        return Category::where("name", $name)->first();
    }

    /**
     * get categories from  array of ids
     *
     * @return Illuminate\Database\Eloquent\Collection
     *
     * @param array $id
     */
    public function getCategories(array $ids): Collection
    {
        return Category::whereIn('id', $ids)
                        ->with(['products'])
                        ->get();
    }
}
