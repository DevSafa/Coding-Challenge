<?php

namespace App\Services;

use App\Exceptions\InvalidContentImage;
use App\Interfaces\Services\ProductCreationServiceInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Repositories\CategoryProductRepositoryInterface;
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
     * store the product
     * store uploaded image
     * store product with categories
     *
     * @param array $values
     */
    public function storeProduct(array $values): Product
    {
        $data = [
            'name'          => $values['name'],
            'description'   => $values['description'],
            'price'         => (float)$values['price'],
            'image'         => $this->generateImageName(
                $values['image'],
                $values['name']
            ),
        ];

        $product = $this->productRepository->store($data);
        $this->uploadImage($values['image'], $data['image']);
        $categories = $this->getProductCategories($values['category']);
        $this->storeProductCategories($categories, $product['id']);

        return $product;
    }


    /**
     * generate a unique image name
     *
     * @param Illuminate\Http\UploadedFile $image
     * @param string $name
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
     * store the image
     *
     * @param Illuminate\Http\UploadedFile $image
     * @param string $imageName
     *
     * @return void
    */
    protected function uploadImage(
        UploadedFile $image,
        string $imageName
    ): void {
        $image->storeAs('public/images', $imageName);
    }

    /**
     * get categories parents of a single category
     * using categoryRepository
     *
     * @param string $name
     *
     * @return array
     */
    protected function getProductCategories(string $name): array
    {
        $id = $this->categoryRepository->getCategory($name)['id'];

        $categories = array();

        array_push($categories, $id);

        $parent = $this->categoryRepository->getParent($id);

        while ($parent->isNotEmpty()) {
            $parentId= $parent[0]['id'];
            array_push($categories, $parentId);
            $parent = $this->categoryRepository->getParent($parentId);
        }

        return $categories;
    }

    /**
     * associate product with categories using
     * categoryProductRepository
     *
     * @param array $categories
     * @param int   $id
     *
     * @return array
     */
    protected function storeProductCategories(array $categories, int $id): void
    {
        $data = collect();
        foreach ($categories as $category) {
            $data->push([
                "product_id" => $id,
                "category_id"=>$category,
            ]);
        }
        $this->categoryProductRepository->store($data->toArray());
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
    public function validateData(array $values, bool $cli): void
    {
        $this->myValidator = new ProductCreationValidator($values, $cli);
        if ($this->myValidator->check()) {
            throw (new ValidationException($this->myValidator));
        }
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
        $error = 0;

        $fileContent = file_get_contents($url);
        if ($fileContent === false) {
            $error = 1;
        }

        $this->tempFile = tmpFile();
        $tempFilePath = stream_get_meta_data($this->tempFile)['uri'];

        file_put_contents($tempFilePath, $fileContent);

        $tempFileObject = new File($tempFilePath);
        if (!str_contains($tempFileObject->getMimeType(), 'image')) {
            $error = 1;
        }
        if ($error) {
            throw new InvalidContentImage("can't get content from url");
        }
        return $tempFileObject;
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
            throw new InvalidContentImage("can't uplaod image");
        }

        return $uploadedFile;
    }
}
