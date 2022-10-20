<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
