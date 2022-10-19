<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* create 5 products */
        $products = Product::factory()->count(5)->create();

        /** create three categories and attach them to products randomly */
        $categories = Category::factory()
                        ->count(3)
                        ->hasAttached($products)
                        ->create();
    }
}
