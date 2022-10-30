<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;

	class Category extends Model
	{
		use HasFactory;

		protected $with = ['children'];

		protected $visible = [
						'id',
						'name',
						'children',
					];

		public function products()
		{
			return $this->belongsToMany(Product::class);
		}

		public function children()
		{
			return $this->hasMany(Category::class , 'parent_id');
		}

		public function parent()
		{
			return $this->belongsTo(Category::class ,'parent_id');
		}
	}
