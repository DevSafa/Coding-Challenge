<?php

namespace App\Services;

use App\Interfaces\ProductServiceInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;

class ProductService implements ProductServiceInterface {

	/**
	 * The product repository instance.
	*/
	protected $productRepository;

	/**
	 *  Illuminate\Support\Collection instance.
	*/
	protected $values;

	/**
	 * Create a new ProductService instance.
	 *
	 * @param  ProductRepository  $productRepository
	 * 
	 * @return void
	*/
	public function __construct(ProductRepositoryInterface $productRepository)
	{
		$this->productRepository = $productRepository;
	}

	/**
	 * get all products
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	*/
	public function index() : EloquentCollection
	{
		return $this->productRepository->index();
	}

	/**
	 * get image extension from image object from  SupportCollection instance
	 *
	 * @return  string
	*/
	protected function getImageExtension() : string
	{
		
		return $this->values['image']->extension();
	}

	/**
	 * get image name from image object from  Supportcollection instance
	 *
	 * @return  string
	*/
	protected function getImageName() : string
	{
		return $this->values['name'];
	}

	/**
	 * generate a unique image name 
	 *
	 * @return  string
	*/
	protected function generateImageName() : string
	{
		return uniqid() . '-' .$this->getImageName(). '.' . $this->getImageExtension();
	}

	/**
	 * getPrice of an image from SupportCollection instance and cast it to float
	 *
	 * @return  float
	*/
	protected function getPrice() : float
	{
		return (float)($this->values['price']);
	}

	/**
	 * the final data to pass to database Repository
	 *
	 * @param  Illuminate\Support\Collection  $values
	 * 
	 * @return  void
	*/
	public function storeProduct(SupportCollection $values) : int 
	{	
		$this->values = $values;

		$collection = collect([
			'name' => $values['name'],
			'description' => $values['description'],
			'price' => $this->getPrice(),
			'image' =>$this->generateImageName()

		]);
		return $this->productRepository->storeProduct(($collection));
	}
}