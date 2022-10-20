<?php

namespace App\Models;

use Hamcrest\Description;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','price','image'];
    
    public function upload($filename,$image)
    {        
        $image->storeAs('images',$filename); 
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    
}
