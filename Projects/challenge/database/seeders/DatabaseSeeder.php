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

        $this->call([
            ProductSeeder::class,
            CategorySeeder::class,
            ProductCategorySeeder::class
        ]);
        // $products = Product::factory()->count(5)->create();

    
        // $categories = Category::factory()
        //                 ->count(3)
        //                 ->hasAttached($products)
        //                 /* every  category has a parent , belongsTo relationship */
        //                 ->for(Category::factory(),"parent")
        //                 /* every category has vhildren hasMany relationship */
        //                 ->has(Category::factory()->count(3),"children")
        //                 ->create();

        // Category::factory()
        //                 ->count(2)
        //                 ->hasAttached($products)
        //                 /* every category has vhildren hasMany relationship */
        //                 ->has(Category::factory()->count(3),"children")
        //                 ->create();


    }
}
