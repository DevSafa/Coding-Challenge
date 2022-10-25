<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        DB::table('products')->insert([
            [
             
                'name' => 'prod-1234-22',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has 
                                ry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                it to make a type specimen book. It has survived not only five centurie',
                'price' => 55.25,
                'image' => "p1.jpeg"
            ],
        ]);

        DB::table('products')->insert([
            [
              
                'name' => 'ApaA-251',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin 
                    literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, 
                    looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word ',
                'price' => 30.25,
                'image' => "p2.jpeg"
            ],
        ]);

        DB::table('products')->insert([
            [
                'name' => 'CALp-45',
                'description' => '"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.',
                'price' => 100,
                'image' => "p3.jpeg"
            ],
        ]);
    }
}
