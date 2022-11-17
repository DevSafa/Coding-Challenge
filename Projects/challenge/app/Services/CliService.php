<?php
namespace App\Services;

use App\Interfaces\ProductServiceInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\CliServiceInterface;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class CliService implements CliServiceInterface
{
    /**
     * a temporary file instance
     * file handle instance with unique id in read-write mode
     * @var  resource|false
     */
    protected $tempFile;

    /**
     * a category service instance
     * @var CategoryService
     */
    protected $categoryService = null;


    /**
     *  a product service instance
     * @var ProductService
     */
    protected $productService = null;

    /**
     * create a new instance of CliService
     * 
     * @param CategoryServiceInterface $categoryService
     * @param ProductServiceInterface $productService
     * @return void
     */
    public function __construct(
        CategoryServiceInterface $categoryService, 
        ProductServiceInterface $productService
    )
    {
        $this->tempFile = tmpFile();
        $this->categoryService  = $categoryService;
        $this->productService  = $productService;
    }

    /**
     * get CategoryService instance
     * @return CategoryServiceInterface
     */
    public function getCategoryService(): CategoryServiceInterface
    {
        return $this->categoryService;
    }

    /**
     * get ProductService instance
     * @return ProductServiceInterface
     */
    public function getProductService(): ProductServiceInterface
    {
        return $this->productService;
    }

    /**
     * get UploadedFile
     * @param File $file
     * @param string $name
     * @return UploadedFile
     */
    public function getUploadFile(File $file, string $name): UploadedFile
    {
        $uploadedFile = new UploadedFile(
            $file->getPathname(), 
            $name, $file->getMimeType(), 
            $file->getSize(), 
            0, 
            false
        );
        return $uploadedFile;
    }

    /**
     * read content of a file store it
     * @param string $url
     * @return File
     */
    public function getFile(string $url): File
    {
        $fileContent = @file_get_contents($url);
         if ($fileContent === false) {
            return null;
        }
        $tempFilePath = stream_get_meta_data($this->tempFile)['uri'];
        
        file_put_contents($tempFilePath, $fileContent);

        $tempFileObject = new File($tempFilePath);

        return $tempFileObject;
    }
}
