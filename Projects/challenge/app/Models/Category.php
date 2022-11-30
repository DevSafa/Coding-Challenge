<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * Get a new factory instance for the model.
     *
     * @param  mixed  $parameters
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    use HasFactory;

    /**
     * The attributes that should be visible in arrays
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'children',
    ];

    /**
     * get The products that belong to a category.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany;
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * get the categories children of a category
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * get category parent of a category
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
