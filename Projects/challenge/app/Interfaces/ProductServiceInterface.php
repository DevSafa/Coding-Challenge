<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;

interface ProductServiceInterface 
{
	public function index() : EloquentCollection;
	public function store(SupportCollection $values);
}