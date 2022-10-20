<?php

namespace App\Models;

use Hamcrest\Description;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    private $name;
    private $description;
    private $price;

    private $category;
    private $image;

    public function __construct($name , $description , $price, $category, $image)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->image = $image;

        
    }

    public function get_name()
    {
        return $this->name;
    }
    public function get_description()
    {
        return $this->description;
    }

    public function get_price()
    {
        return $this->price;
    }

    public function get_category()
    {
        return $this->category;
    }

    public function get_image()
    {
        return $this->image;
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    
}
