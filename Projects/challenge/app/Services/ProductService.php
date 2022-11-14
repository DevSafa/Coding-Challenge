<?php

namespace App\Services;

use App\Interfaces\ProductServiceInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Http\UploadedFile as Image;

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
	public function index() :array
	{
		return $this->productRepository->index()->toArray();
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

	protected function uploadImage(Image $image, string $name) : void 
	{
		$image->storeAs('public/images',$name);
	
	}

	/**
	 * the final data to pass to database Repository
	 * 
	 * uploading image in storage
	 *
	 * @param  Illuminate\Support\Collection  $values
	 * 
	 * @return  void
	*/
	public function storeProduct(SupportCollection $values) : void
	{	
		$this->values = $values;

		$collection = collect([
			'name' => $values['name'],
			'description' => $values['description'],
			'price' => $this->getPrice(),
			'image' =>$this->generateImageName()
		]);
		
		$this->productRepository->storeProduct(($collection),$values['categories']);
		$this->uploadImage($values['image'],$collection['image']);
	}
}