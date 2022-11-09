<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	private $categoryService;

	public function __construct(CategoryServiceInterface $categoryService)
	{
		$this->categoryService = $categoryService;
	}

	public function index()
	{
		return $this->categoryService->index();
	}
}
