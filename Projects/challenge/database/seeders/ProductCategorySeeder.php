<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('category_product')->insert([
            [
                'product_id'  => 1,
                'category_id' => 1
            ],
        ]);

        DB::table('category_product')->insert([
            [
                'product_id' => 2,
                'category_id'=> 1
            ],
        ]);
        DB::table('category_product')->insert([
            [
                'product_id' => 2,
                'category_id'=> 2
            ],
        ]);
        DB::table('category_product')->insert([
            [
                'product_id' => 3,
                'category_id'=> 3
            ],
        ]);
   
        DB::table('category_product')->insert([
            [
                'product_id' => 3,
                'category_id'=> 1
            ],
        ]);
          
    }
}