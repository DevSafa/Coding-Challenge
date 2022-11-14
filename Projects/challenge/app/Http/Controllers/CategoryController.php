<?php
namespace App\Http\Controllers;

use App\Interfaces\CategoryServiceInterface;

class CategoryController extends Controller
{
	/**
	 * The category service instance.
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
	 * to get all categories and their sub categories
	 *
	 * @return  array
	*/
	public function index() : array
	{
		return $this->categoryService->index();
	}
}
