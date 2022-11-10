<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface CategoryRepositoryInterface 
{
	public function index() : EloquentCollection;
}