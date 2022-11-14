<?php
namespace App\Services;

use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CategoryService implements CategoryServiceInterface {
	private $categoryRepository;

	/**
	 * Create a new CategoryService instance.
	 *
	 * @param  CategoryRepository  $categoryRepository
	 * 
	 * @return void
	*/
	public function __construct(CategoryRepositoryInterface $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * get all categories
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	*/
	public function index() : EloquentCollection
	{
		return $this->categoryRepository->index();
	}

	public function getCategoryId(string $name) : int
	{
		return $this->categoryRepository->getCategoryId($name);
	}

}