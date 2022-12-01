<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EndPointTest extends TestCase
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
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CategorySeeder::class);
        Storage::fake('/public/images');

    }


    /**
     * test creation of a product successfully
     *
     * @return void
     */
    public function test_creation_product_response201(): void
    {

        $data = $this->getFakeData();
        $response = $this->sendPostRequest($data);
        $response->assertStatus(201);
    }

    /**
     * seed memory database with some fake categories
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
            "image"         => File::create($imageName, 2000),
            "name"          => $this->faker->name,
            "description"   => $this->faker->paragraph,
            "price"         => $this->faker->randomFloat(2, 10, 200),
            "category"      => Category::find($id)->name,
        ];
    }


    // /**
    //  * test creation of a product successfully
    //  *
    //  * @return void
    //  */
    // public function test_creation_product_database_successfully(): void
    // {
    //     Storage::fake('/public/images');

    //     $data = $this->getFakeData();
    //     $response = $this->sendPostRequest($data);

    //     $this->assertDatabaseHas(
    //         'products',
    //         [
    //         'name'          => $data['name'],
    //         'description'   => $data['description'],
    //         'price'         => $data['price'],
    //         'image'         => $response['image']
    //         ]
    //     );
    // }

    /**
     * send a post request to my endpoint with some fake data
     *
     * @return Illuminate\Testing\TestResponse
     */
    protected function sendPostRequest(array $data): TestResponse
    {
        Storage::fake('/public/images');

        $response = $this->json(
            'POST',
            '/create',
            [
                "name"          => $data['name'],
                "description"   => $data['description'],
                "price"         => $data['price'],
                "image"         => $data['image'],
                "category"      => $data['category']
            ]
        );
        return $response;
    }

    // /*
    //  * test validation of data failed.
    //  *
    //  * @return void
    //  */
    // public function test_validation_failed_existence_product_database(): void
    // {
    //     Storage::fake('/public/images');

    //     $data = $this->getFakeData();
    //     $product = Product::factory()->create();
    //     $data['name'] = $product->name;
    //     $this->sendPostRequest($data);

    //     $this->assertDatabaseMissing(
    //         'products',
    //         [
    //         'name'          => $data['name'],
    //         'description'   => $data['description'],
    //         'price'         => $data['price'],
    //         ]
    //     );
    // }

    // /**
    //  * @return void
    //  */
    // public function test_failed_creation_product_response400(): void
    // {
    //     Storage::fake('/public/images');

    //     $data = $this->getFakeData();
    //     $data['category'] = $this->faker->name;
    //     $response = $this->sendPostRequest($data);
    //     $response->assertStatus(400);
    // }

    // /**
    //  * test successful upload of an image
    //  *
    //  * @return void
    //  */
    // public function test_successful_upload_image(): void
    // {
    //     Storage::fake('/public/images');

    //     $data = $this->getFakeData();
    //     $response = $this->sendPostRequest($data);
    //     Storage::assertExists('/public/images/'.$response['image']);
    // }
}
