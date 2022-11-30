<?php

namespace App\Services;

use App\Exceptions\InvalidContentImageException;
use App\Interfaces\Services\ProductCreationServiceInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Repositories\CategoryProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Validators\ProductCreationValidator;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class ProductCreationService implements ProductCreationServiceInterface
{
    /**
     * @var resource|false
     */
    protected $tempFile;

    /**
     * @var App\Interfaces\Repositories\CategoryRepositoryInterface
     */
    protected $categoryRepository = null;

    /**
     * @var App\Interfaces\Repositories\CategoryProductRepositoryInterface;
     */
    protected $categoryProductRepository = null;

    /**
     * @var App\Interfaces\Repositories\ProductRepositoryInterface
     */
    protected $productRepository = null;

    /**
     * @var App\Validators\ProductCreationValidator
     */
    protected $myValidator = null;

    /**
     * Create a new ProductCreationService  instance
     *
     * @param App\Interfaces\Services\ProductCreationServiceInterface
     *
     * @return void
    */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        CategoryProductRepositoryInterface $categoryProductRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->categoryProductRepository = $categoryProductRepository;
    }

    /**
     * validate input using ProductCreationValidator
     * throws validation exception in case of errros
     *
     * @param array $values
     * @param bool  $cli
     *
     * @return void
     */
    public function validateData(array $values, bool $cli): bool
    {
        $this->myValidator = new ProductCreationValidator($values, $cli);
        if ($this->myValidator->check()) {
            throw (new ValidationException($this->myValidator));
        }
        return true;
    }

    /**
     *
     * @param Illuminate\Http\UploadedFile  $image
     * @param string                        $name
     *
     * @return  string
    */
    protected function generateImageName(
        UploadedFile $image,
        string $name
    ): string {
        $imageExtension = $image->extension();
        return uniqid() . '-' .$name . '.' . $imageExtension;
    }

    /**
     * @param array $values
     *
     * @return array
     */
    protected function prepareDataForProductRepo(array $values): array
    {
        return [
            'name'          => $values['name'],
            'description'   => $values['description'],
            'price'         => (float)$values['price'],
            'category'      => $values['category'],
            'image'         => $this->generateImageName(
                $values['image'],
                $values['name']
            ),
        ];
    }

    /**
     * @param array $categories
     * @param int    $id
     *
     * @return array
     */
    protected function prepareDataForCategoryProductRepo(
        array $categories,
        int $id
    ): array {
        $data = array();

        foreach ($categories as $category) {
            array_push($data, [
                "product_id" => $id,
                "category_id"=>$category,
            ]);
        }
        return $data;
    }

    /**
     * store the image
     *
     * @param Illuminate\Http\UploadedFile  $image
     * @param string                        $imageName
     *
     * @return void
    */
    protected function storeImage(
        UploadedFile $image,
        string $imageName
    ): void {
        $image->storeAs('public/images', $imageName);
    }

    /**
     * get all parents of a category
     *
     * @param App\Models\Category
     *
     * @return array
     */
    protected function getCategoriesIds(Category $parent): array
    {
        $ids = collect();
        $ids = $ids->merge($parent['id']);
        if ($parent['parent']) {
            $ids = $ids->merge($this->getCategoriesIds($parent['parent']));
        }
        return $ids->toArray();
    }

    /**
     * @param array $values
     *
     * @return Product
     */
    protected function toProductRepository(array $values): Product
    {
        $data = $this->prepareDataForProductRepo($values);

        $product = $this->productRepository->store($data);
        return $product;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected function toCategoryProductRepository(
        string $name
    ): void {
        $parent = $this->categoryRepository->getCategoryByName($name);

        $categoriesIds = $this->getCategoriesIds($parent);
        // dd($parent);
        $data = $this->prepareDataForCategoryProductRepo(
            $categoriesIds,
            $parent['id']
        );
        $this->categoryProductRepository->store($data);
    }

     /**
     * @param array $values
     *
     * @return Product
     */
    public function storeProduct(array $values): Product
    {
        $product = $this->toProductRepository($values);
        $this->toCategoryProductRepository($values['category']);

        $this->storeImage($values['image'], $product['image']);

        return $product;
    }

    /**
     * method for CLI.
     * read content  from url
     * and put it in a File
     *
     * @param string $url
     *
     * @return Illuminate\Http\File
     */
    public function getFile(string $url): File
    {
        $fileContent = $this->readUrlContent($url);
        $file = $this->putContentInFile($fileContent);
        return $file;
    }

    /**
     * method for CLI
     * get content of a file from url
     *
     * @param string $fileContent
     *
     * @return File
     */
    protected function putContentInFile(string $fileContent): File
    {
        $this->tempFile = tmpFile();
        $tempFilePath = stream_get_meta_data($this->tempFile)['uri'];

        file_put_contents($tempFilePath, $fileContent);

        $tempFileObject = new File($tempFilePath);
        if (!str_contains($tempFileObject->getMimeType(), 'image')) {
            throw new InvalidContentImageException("content of url not valid");
        }
        return $tempFileObject;
    }

    /**
     * method for CLI
     * put content in File object
     *
     * @param string $url
     *
     * @return string
     */
    protected function readUrlContent(string $url): string
    {
        $fileContent = file_get_contents($url);
        if ($fileContent === false) {
            throw new InvalidContentImageException("content of url not valid");
        }
        return $fileContent;
    }

    /**
     * method for CLI
     * get UploadedFile
     *
     * @param File      $file
     * @param string    $name
     *
     * @return Illuminate\Http\UploadedFile
     */
    public function getUploadFile(File $file, string $name): UploadedFile
    {
        $uploadedFile = new UploadedFile(
            $file->getPathname(),
            $name,
            $file->getMimeType(),
            $file->getSize(),
            0,
            false
        );

        if ($uploadedFile === null) {
            throw new InvalidContentImageException("can't uplaod image");
        }

        return $uploadedFile;
    }
}
