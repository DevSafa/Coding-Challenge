<?php

namespace App\Services;

use App\Interfaces\ProductCategoryServiceInterface;
use App\Interfaces\ProductCategoryRepositoryInterface;
use Illuminate\Support\Collection as SupportCollection;

class ProductCategoryService implements ProductCategoryServiceInterface {

	/**
	 * The ProductCategory repository instance.
	*/
	protected $productCategoryRepository;

	/**
	 *  Illuminate\Support\Collection instance.
	*/
	protected $values;

	/**
	 * Create a new ProductCategoryService instance.
	 *
	 * @param  ProductCategoryRepository  $productCategoryRepository
	 * 
	 * @return void
	*/
	public function __construct(ProductCategoryRepositoryInterface $productCategoryRepository)
	{
		$this->productCategoryRepository = $productCategoryRepository;
	}

	/**
	 * call the productRepository instance to insert data
	 *
	 * @param  use Illuminate\Support\Collection  $values
	 * 
	 * @return void
	*/
    public function addProductCategory(SupportCollection $values) : void
    {
        $this->productCategoryRepository->addProductCategory($values);
    }

}