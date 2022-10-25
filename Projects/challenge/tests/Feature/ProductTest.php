<?php

namespace Tests\Feature;


use Database\Seeders\CategorySeeder;
use Illuminate\Http\Testing\File;
use Tests\TestCase;



class ProductTest extends TestCase
{
    // on every load of this test , the database will be refreshed
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->seed(CategorySeeder::class);

        
        $file = File::create('image.png',100);
        $response = $this->json('POST','/create',
            [
                "image" => $file,
                "name" => "product6",
                "description" => "awesome product",
                "price" => 13.25,
                "category" => 1
            ]
        );  
        $image = $response['image'];
        
        $this->assertDatabaseHas('products' ,['name' => "product6", 'description' => 'awesome product' , 'price' => 13.25 ,'image' => $image]);
      
        
        
        $response = $this->post('/create',
        [
            "image" => $file,
            "name" => "",
            "description" => "awesome product",
            "price" => 13.25,
            "category" => 1
        ]);
        $response->assertStatus(400);
        




        $response = $this->post('/create',
        [
            "image" => $file,
            "name" => "ppp-1235",
            "description" => "awesome product",
            "price" => 13.25,
            "category" => 2
        ]);

        $response->assertStatus(201);

        $response = $this->post('/create',
        [
            "image" => $file,
            "name" => "pp456",
            "description" => "awesome product",
            "price" => 13.25,
            "category" => 1000
        ]);
        $response->assertStatus(400);
       

    }
}
