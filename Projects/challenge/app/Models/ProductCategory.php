<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
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
     * The table associated with the model.
     *
     * @var string
    */
    protected $table="category_product";
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	*/
    protected $fillable = [
        'product_id',
        'category_id'
    ];

    /**
     * Get Product
     * 
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get Category
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
