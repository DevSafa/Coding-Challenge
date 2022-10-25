<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	private $_name;
	protected $fillable = ['name','description','price','image'];

	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}

	public function setNameImage($name)
	{
		$this->_name = $name;
	}

	public function getImageName()
	{
		return $this->_name;
	}
}
