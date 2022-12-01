<?php

namespace Tests\Unit;

use App\Exceptions\InvalidContentImageException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Repositories\CategoryProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Services\ProductCreationService;
use Database\Seeders\CategorySeeder;
use Illuminate\Http\File;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class ProductCreationServiceCliTest extends TestCase
{
    /**
     * use RefreshDatabase trait
     */
    use RefreshDatabase;

    /**
     * use withFaker trait
     */
    use WithFaker;

    /**
     * @var ProductCreationService
     */
    protected $productCreationService;

    /**
     * Mock repositories : create fake instances
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        /** Mock repositories */
        $productRepository = $this->createMock(
            ProductRepository::class
        );
        $categoryRepository = $this->createMock(
            CategoryRepository::class
        );
        $categoryProductRepository = $this->createMock(
            CategoryProductRepository::class
        );

        $this->productCreationService = new ProductCreationService(
            $categoryRepository,
            $productRepository,
            $categoryProductRepository
        );
        $this->seed(CategorySeeder::class);
    }

    /**
     * @return string
     */
    protected function inValidUrl(): string
    {
        $inValidUrls = array();
        array_push(
            $inValidUrls,
            "https://en.wikipedia.org/wiki/Main_Page",
            "https://www.york.ac.uk/teaching/cws/wws/webpage1.html",
            "https://www.deepl.com/en/translator"
        );
        $key = array_rand($inValidUrls);
        return $inValidUrls[$key];
    }

    /**
     * @return string
     */
    protected function validUrl(): string
    {
        $validUrls =array();
        array_push(
            $validUrls,
            "https://encrypted-tbn0.gstatic.com/images".
            "?q=tbn:ANd9GcRMqgUBWhVfuZgOFLXN18AEcWzdKfeqSYUrJA&usqp=CAU",
            "https://encrypted-tbn0.gstatic.com/images".
            "?q=tbn:ANd9GcQICzjpCxzR2LN-sypem9odK-vQ3M6IBg33GA&usqp=CAU",
            "https://encrypted-tbn0.gstatic.com/images".
            "?q=tbn:ANd9GcSxcFncjSRYjJWiHjU_2ksLkcSNdh4gG9lnUA&usqp=CAU",
        );

        $key = array_rand($validUrls);
        return $validUrls[$key];
    }

    /**
     * @return void
     */
    public function test_get_Invalid_image_from_url(): void
    {
        $this->expectException(InvalidContentImageException::class);
        $this->expectExceptionMessage('content of url not valid');
        $this->productCreationService->getFile($this->inValidUrl());
    }

    /**
     * @return void
     */
    public function test_get_valid_image_from_url(): void
    {
        $return = $this->productCreationService->getFile($this->validUrl());
        $this->assertTrue($return instanceof File);
    }

    /**
     * @return void
     */
    public function test_get_file_upload_format(): void
    {
        $return = $this->productCreationService->getFile($this->validUrl());
        $name = $this->faker->name;
        $return = $this->productCreationService->getUploadFile($return, $name);

        $this->assertTrue($return instanceof UploadedFile);
        $this->assertEquals($return->getClientOriginalName(), $name);
    }

    /**
     * @return void
     */
    public function test_valid_data(): void
    {
        $values = $this->getValidData();

        $return = $this->productCreationService->validateData($values, false);
        $this->assertTrue($return);
    }

    /**
     * @return void
     */
    public function test_Invalid_data(): void
    {
        $values = $this->getInValidData();
        $this->expectException(ValidationException::class);

        $return = $this->productCreationService->validateData(
            $values,
            false
        );
    }

    /**
     * @return array
     */
    protected function getValidData(): array
    {
        $imageName = $this->faker->name .'.png';
        $category = Category::factory()->create();
        return
        [
            "image"         => TestingFile::create($imageName, 2000),
            "name"          => $this->faker->name,
            "description"   => $this->faker->paragraph,
            "price"         => $this->faker->randomFloat(2, 10, 200),
            "category"      => $category['name']
        ];
    }

    /**
     * @return array
     */
    protected function getInvalidData(): array
    {
        return
        [
            "image"         => "Invalid IMage",
            "name"          => $this->faker->name,
            "description"   => $this->faker->paragraph,
            "price"         => $this->faker->randomFloat(2, 10, 200),
            "category"      => "Invalid Catgeory"
        ];
    }
}
