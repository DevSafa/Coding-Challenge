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
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Http\UploadedFile as HttpUploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use ReflectionClass;

class WebProductCreationTest extends TestCase
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
     * test getting array of ids
     *
     * @return void
     */
    public function test_parents_of_category(): void
    {
        $count = Category::count();
        $id = $this->faker->numberBetween(1, $count);
        $method = $this->reflection->getMethod('getCategoriesIds');
        $method->setAccessible(true);

        $result = $method->inVokeArgs(
            $this->productCreationService,
            [Category::find($id)]
        );

        $this->assertTrue(is_array($result));

        $this->assertTrue(in_array($id, $result));
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
     * test prepared data for categoryProduct repository
     *
     * @return void
     */
    public function test_prepare_data_for_category_product_repository(): void
    {
        $count = Category::count();
        $id = $this->faker->numberBetween(1, $count);
        $categories = $this->getCategories($id);

        $method = $this->reflection->getMethod(
            'prepareDataForCategoryProductRepo'
        );
        $method->setAccessible(true);

        $result = $method->inVokeArgs(
            $this->productCreationService,
            [$categories,$id]
        );

        foreach ($categories as $category) {
            $this->assertContains([
                "product_id" => $id,
                "category_id" => $category
            ], $result);
        }
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
     * @param $id
     *
     * @return array
     */
    protected function getCategories(int $id): array
    {
        $method = $this->reflection->getMethod('getCategoriesIds');
        $method->setAccessible(true);

        $categories = $method->inVokeArgs(
            $this->productCreationService,
            [Category::find($id)]
        );
        return $categories;
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
