<?php
namespace App\Interfaces;


interface CategoryServiceInterface 
{
	public function index() : array;
	public function getCategories(string $name) : array;
	public function getProducts(int $id) : array ;
}