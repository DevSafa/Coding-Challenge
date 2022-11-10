<?php
namespace App\Http\Controllers;

use App\Interfaces\CategoryServiceInterface;

class CategoryController extends Controller
{
	/**
	 * The categoryService instance.
	*/
	protected $categoryService;

	/**
	 * Create a new CategoryController instance.
	 *
	 * @param  CategoryService  $categoryService
	 * 
	 * @return void
	*/
	public function __construct(CategoryServiceInterface $categoryService)
	{
		$this->categoryService = $categoryService;
	}

	/**
	 * Call the  @method index in CategoryService instance 
	 *
	 * @return  array
	*/
	public function index() : array
	{
		return $this->categoryService->index()->toArray();
	}
}
