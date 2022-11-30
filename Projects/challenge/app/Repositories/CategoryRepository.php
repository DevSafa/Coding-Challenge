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
                ->with(['children'])
                ->get();
    }

    /**
     * get products of a specific category
     *
     * @param int $id
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function filter(int $id): Collection
    {
        return Category::find($id)
                    ->products()
                    ->get();
    }

    /**
     * @param   string $name
     * 
     * @return App\Models\Category
     */
    public function getCategoryByName(string $name): Category
    {
        return  Category::Where('name', $name)
                    ->with(['parent'])
                    ->first();
    }
}
