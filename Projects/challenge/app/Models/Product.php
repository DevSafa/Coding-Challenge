<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /** define the many to many relationship between Product and Category , a product belongs to n category
     * Defining The Inverse Of The Relationship Many to Many
     * to get categories of a Product ==> use the method categories() on Product model 
    */

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    
}
