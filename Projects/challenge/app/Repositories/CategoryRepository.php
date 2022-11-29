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
        return Category::whereNull('parent_id')->get();
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
        return Category::find($id)->products()->get();
    }

    /**
     * get parent of a category
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getParent(int $id): Collection
    {
        return Category::find($id)->parent()->get();
    }

    /**
     * get category with specific name
     *
     * @param string $name
     *
     * @return App\Models\Category
     */
    public function getCategory(string $name): Category
    {
        return Category::firstWhere('name', $name);
    }

    /**
     * get collection of ids
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getCategoriesIds(): Collection
    {
        return Category::select('id')->get();
    }
}
