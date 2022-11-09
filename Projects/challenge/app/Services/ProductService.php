<?php
namespace App\Services;

use App\Interfaces\ProductServiceInterface;
use App\Interfaces\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface {

	private $productRepository;

	public function __construct(ProductRepositoryInterface $productRepository)
	{
		$this->productRepository = $productRepository;
	}

	public function injectionTest()
	{
		return $this->productRepository->injectionTest();
	}
}