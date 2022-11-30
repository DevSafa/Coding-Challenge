<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Repositories\CategoryProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Services\ProductCreationService;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use ReflectionClass;

class ProductCreationServiceWebTest extends TestCase
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
     * @var App\Services\ProductCreationService
     */
    protected $productCreationService;

    /**
     * used to fake visibility of a class method
     *
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Mock repositories : create fake instances
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        /** Mock repositories */
        /**to */
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
        Storage::fake('/public/images');

        $this->reflection = new ReflectionClass(get_class($this->productCreationService));
    }

    /**
     * test store Image protected function
     *
     * @return void
     */
    public function test_store_image(): void
    {
        $imageName = $this->faker->name .'.png';
        $image = TestingFile::create($imageName, 2000);

        $method = $this->reflection->getMethod('storeImage');
        $method->setAccessible(true);

        $method->invokeArgs(
            $this->productCreationService,
            [$image,$imageName]
        );

        Storage::assertExists('/public/images/'.$imageName);
    }


    /**
     * test generation of image name
     *
     * @return void
     */
    public function test_generate_image_name(): void
    {
        $imageName = $this->faker->name .'.jpg';
        $image = TestingFile::create($imageName, 100000);

        $method = $this->reflection->getMethod('generateImageName');
        $method->setAccessible(true);

        $result = $method->inVokeArgs(
            $this->productCreationService,
            [$image,$imageName]
        );
        $this->assertTrue(str_contains(
            $result,
            '-' .$imageName
        ));
    }

    /**
     * test prepared data for product respository
     *
     * @return void
     */
    public function test_prepare_data_for_product_repository(): void
    {
        $data = $this->getFakeData();
        $method = $this->reflection->getMethod('prepareDataForProductRepo');
        $method->setAccessible(true);

        $result = $method->inVokeArgs(
            $this->productCreationService,
            [$data]
        );
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('image', $result);

        $this->assertContains($data['name'], $result);
        $this->assertContains($data['price'], $result);
    }

    /**
     * test prepared data for category product repository
     *
     * @return void
     */
    public function test_prepare_data_for_category_product_repository(): void
    {
        $method = $this->reflection->getMethod(
            'prepareDataForCategoryProductRepo'
        );
        $method->setAccessible(true);

        $productId = $this->faker->numberBetween(10, 30);
        $parentId = $this->faker->numberBetween(1, 20);

        $result = $method->inVokeArgs(
            $this->productCreationService,
            [$productId,$parentId]
        );
        $this->assertContains(
            ["product_id" => $productId,
            "category_id" => $parentId],
            $result
        );
    }


    public function test_failed_validation()
    {
        $method = $this->reflection->getMethod('validateData');
        $method->setAccessible(true);

        $this->expectException(ValidationException::class);

        $invalidData = $this->getFakeInvalidData();
        $method->inVokeArgs(
            $this->productCreationService,
            [$invalidData,false]
        );
    }

    /**
     * get fake data
     *
     * @return array
     */
    protected function getFakeData(): array
    {
        $count = Category::count();
        $id = $this->faker->numberBetween(1, $count);
        $imageName = $this->faker->name .'.png';

        return
        [
            "image"         => TestingFile::create($imageName, 2000),
            "name"          => $this->faker->name,
            "description"   => $this->faker->paragraph,
            "price"         => $this->faker->randomFloat(2, 10, 200),
            "category"      => Category::find($id)->name,
        ];
    }

    protected function getFakeInvalidData(): array
    {
        return
        [
            "image"         => "",
            "name"          => $this->faker->name,
            "description"   => $this->faker->paragraph,
            "price"         => "non number",
            "category"      => "non existed category",
        ];
    }
}
