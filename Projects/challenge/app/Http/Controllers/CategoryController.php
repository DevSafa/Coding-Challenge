<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	private $categoryService;

	public function __contruct(CategoryServiceInterface $categoryService)
	{
		$this->categoryService = $categoryService;
	}
}
