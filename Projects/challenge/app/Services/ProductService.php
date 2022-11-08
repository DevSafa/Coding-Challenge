<?php
namespace App\Services;

use App\Interfaces\ProductServiceInterface;
use App\Interfaces\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface {

	private $productRepository;

	public function __contruct(ProductRepositoryInterface $productRepository)
	{
		$this->productRepository = $productRepository;
	}
}