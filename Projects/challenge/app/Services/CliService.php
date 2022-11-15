<?php

namespace App\Services;

use App\Interfaces\ProductServiceInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\CliServiceInterface;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;


class CliService implements CliServiceInterface
{
    /**
     * a temporary file instance | file handle instance with unique id in read-write mode
     * 
     * @var  resource|false
     */
    protected $tempFile;

    /**
     *  a category service instance
     * 
     * @var App\Services\CategoryService
     */
    protected $categoryService;


    /**
     *  a product service instance
     * 
     * @var App\Services\ProductService
     */
    protected $productService;

    /**
     * create a new instance of CliService
     * 
     * @param App\Interfaces\CategoryServiceInterface $categoryService
     * 
     * @param App\Interfaces\ProductServiceInterface $productService
     * 
     * @return void
     */
    public function __construct(CategoryServiceInterface $categoryService ,
                                ProductServiceInterface $productService)
    {
        $this->tempFile = tmpFile();
        $this->categoryService  = $categoryService;
        $this->productService  = $productService;
    }
    
    /**
     * get CategoryService instance
     * 
     * @return App\Interfaces\CategoryServiceInterface
     */
    public function getCategoryService() : CategoryServiceInterface
    {
        return $this->categoryService;
    }

    /**
     * get ProductService instance
     * 
     * @return App\Interfaces\ProductServiceInterface
     */
    public function getProductService() : ProductServiceInterface
    {
        return $this->productService;
    }

    /**
     * get UploadedFile
     * 
     * @param Illuminate\Http\File $file
     * 
     * @param string $name
     * 
     * @return  Illuminate\Http\UploadedFile
     */
    public function getUploadFile(File $file , string $name) : UploadedFile
    {
        $uploadedFile = new UploadedFile
            (
                $file->getPathname(),
                $name,
                $file->getMimeType(),
                $file->getSize(),
                0,
                false 
            );
        return  $uploadedFile;
    }

    /**
     * read content of a file store it
     * 
     * @param string $url
     * 
     * @return  Illuminate\Http\File
     */
    public function getFile(string $url) : File
    {
        $fileContent =  @file_get_contents($url);
       
        $tempFilePath = stream_get_meta_data($this->tempFile)['uri'];
        
        file_put_contents($tempFilePath, $fileContent);

        $tempFileObject = new File($tempFilePath);

        return $tempFileObject;
    }

}