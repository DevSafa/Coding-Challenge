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
                        /* every  category has a parent , belongsTo relationship */
                        ->for(Category::factory(),"parent")
                        /* every category has vhildren hasMany relationship */
                        ->has(Category::factory()->count(3),"children")
                        ->create();

        // Product::factory()->count(4)->create();
        Category::factory()
                        ->count(2)
                        ->hasAttached($products)
                        /* every category has vhildren hasMany relationship */
                        ->has(Category::factory()->count(3),"children")
                        ->create();


    }
}
