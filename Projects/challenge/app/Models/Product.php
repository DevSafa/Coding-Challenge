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

    /* define the self relationship  in Category table  => oneToMany self relationship */
    /**
     * A one-to-many relationship is used to define relationships where a single 
     * model is the parent to one or more child models 
     * 
     */
    /** every category has children */
  
    public function children()
    {
        return $this->hasMany(Category::class , 'parent_id');
    }

    /* every category has a parent : single parent */
    /* One To Many (Inverse) / Belongs To */
    public function parent()
    {
        return $this->belongsTo(Category::class ,'parent_id');
    }

    
}
