<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Tests\TestCase;

class ProductTest extends TestCase
{
    // on every load of this test , the database will be refreshed
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        
        //100 is the size in KB
     
        // $file = File::create('image.png',100);
        // $this->json('POST','/create',[
            
        //     "name" => "safaaaaaa",
        //     "description" => "hello wolrddd",
        //     "price" => 13.25,
        //     "image" => "shksdjfljl.png",
            
        // ]);
        $this->assertDatabaseHas('products' ,['name' => "prod1"]);
        // $this->assertTrue(true);
    }
}
