<?php

namespace App\Services;

use App\Interfaces\ProductServiceInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Http\UploadedFile as Image;

class ProductService implements ProductServiceInterface 
{
    /**
     * The product repository instance.
     * @var ProductRepositoryInterface
    */
    protected $productRepository = null;

    /**
     * SupportCollection instance.
     * @var SupportCollection
    */
    protected $values = null;

    /**
     * Create a new ProductService instance
     * @param  ProductRepository  $productRepository
     * @return void
    */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * get all products
     * @return  array
    */
    public function index(): array
    {
        return $this->productRepository->index()->toArray();
    }

    /**
     * get image extension from image object from $values
     * @return  string
    */
    protected function getImageExtension(): string
    {
        return $this->values['image']->extension();
    }

    /**
     * get image name from image object from $values
     * @return  string
    */
    protected function getImageName(): string
    {
        return $this->values['name'];
    }

    /**
     * generate a unique image name 
     * @return  string
    */
    protected function generateImageName(): string
    {
        return uniqid()
                . '-' 
                .$this->getImageName()
                . '.' 
                . $this->getImageExtension();
    }

    /**
     * getPrice of an image from $values cast it to float
     * @return  float
    */
    protected function getPrice(): float
    {
        return (float)($this->values['price']);
    }


    /**
     * store image 
     * @param Image $image
     * @param string $name
     * @return void
    */
    protected function uploadImage(Image $image, string $name): void 
    {
        $image->storeAs('public/images',$name);

    }

    /**
     * the final data to pass to product Repository
     * uploading image in storage
     
     * @param  SupportCollection  $values
     * @return  array
    */
    public function storeProduct(SupportCollection $values): array
    {	
        $this->values = $values;

        $collection = collect([
            'name' => $values['name'],
            'description' => $values['description'],
            'price' => $this->getPrice(),
            'image' =>$this->generateImageName()
        ]);
        
        $product = $this->productRepository
                    ->storeProduct(($collection), $values['categories']);
        $this->uploadImage($values['image'], $collection['image']);
        return $product;
    }
}
