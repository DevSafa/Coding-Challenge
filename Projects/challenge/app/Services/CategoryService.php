<?php
namespace App\Services;

use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface {

	private $categoryRepository;

	public function __construct(CategoryRepositoryInterface $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}
}