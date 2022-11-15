<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Testing\File;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\CreateProductRequest;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;


class ProductCreationTest extends TestCase
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
     * test creation of a product successfully
     * 
     * response status must be 201
     * 
     * @return void 
     */
    public function test_creation_product_response201() : void 
    {

        $data = $this->getFakeData();

        $response = $this->sendPostRequest($data); 
        $response->assertStatus(201);
  
    }

    /**
     * test creation of a product successfully
     *
     * the product must be created in database
     * 
     * @return void
     */

    public function test_creation_product_database_successfully() : void 
    { 

        $data = $this->getFakeData();

        $response = $this->sendPostRequest($data);
        $this->assertDatabaseHas('products' ,
                                ['name' => $data['name'], 
                                'description' => $data['description'] ,
                                'price' => $data['price'],
                                'image' => $response['image']]);

    }

    /**
     * 
     * test validation of data failed.
     * 
     * because  product name already exist.
     * 
     * the product must not be created in database
     * 
     * @return void
     */
    public function test_validation_failed_existence_product_database()
    {

        $data = $this->getFakeData();

        $product = Product::factory()->create();

        $data['name'] = $product->name;

        $response = $this->sendPostRequest($data);

        $this->assertDatabaseMissing('products' ,
                                [
                                    'name' => $data['name'], 
                                    'description' => $data['description'] ,
                                    'price' => $data['price'],
                                ]);
    }

    /**
     * 
     * test validation of data failed.
     * 
     * because category name does not exist in database.
     * 
     * response status code must be 400
     * 
     * @return void
     */
    public function test_failed_creation_product_response400() : void 
    {

        $data = $this->getFakeData();

        $data['category'] = $this->faker->name;

        $response = $this->sendPostRequest($data);

        $response->assertStatus(400);
        
    }
    
    /**
     * test successful upload of an image 
     * 
     * check if the image name exist in fake strorage /public/images
     * 
     * @return void
     */
    public function test_successful_upload_image() : void 
    {
        Storage::fake('/public/images');
        $data = $this->getFakeData();

        $response = $this->sendPostRequest($data);
        Storage::assertExists('/public/images/'.$response['image']);

    }

    /**
     * seed memory database with some fake categories
     * 
     * create some fake data with help if faker
     * 
     * @return array
     */
    private function getFakeData() : array
    {
        Storage::fake();

        $this->seed(CategorySeeder::class);
        $count = Category::count();
        $id = $this->faker->numberBetween(0,$count - 1);
        $imageName = $this->faker->name() .'.png';

        return
        [
            "image" => File::create($imageName,2000),
            "name" => $this->faker->name,
            "description" => $this->faker->paragraph,
            "price" => $this->faker->randomFloat(2,10,200),
            "category" => Category::find($id)->name,
        ];
       
    }

    /**
     * send a post request to my endpoint with some fake data
     * 
     * @return Illuminate\Testing\TestResponse 
     */
    private function sendPostRequest(array $data) :TestResponse
    {
        $response = $this->json('POST','/products',
        [
            "name" => $data['name'],
            "description" => $data['description'],
            "price" => $data['price'],
            "image" => $data['image'],
            "category" => $data['category']
        ]);
        return $response;
    }



  
}
