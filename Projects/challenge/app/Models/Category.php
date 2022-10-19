<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *  Eloquent, an object-relational mapper (ORM) that makes it enjoyable 
 * to interact with your database. When using Eloquent, each database table 
 * has a corresponding "Model" that is used to interact with that table. 
 * In addition to retrieving records from the database table, Eloquent 
 * models allow you to insert, update, and delete records from the table as well
 */
class Category extends Model
{
    use HasFactory;

    /** define many to many RELATIONSHIP IN ELOQUENT MODEL  a category can have many products */
    /* to get products of a Category ==> use the method products on Category Model */
    public function products()
    {
        return $this->belongsToMany(Product::class);
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
