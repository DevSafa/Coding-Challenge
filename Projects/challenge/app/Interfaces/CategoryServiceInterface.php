<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface CategoryServiceInterface 
{
	public function index() : EloquentCollection;
	public function getCategoryId(string $name) : int;

}