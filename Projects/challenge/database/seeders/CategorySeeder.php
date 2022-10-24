<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insertingd ata using query builder
        DB::table('categories')->insert([
            [
                'name' => 'Cosmetics',
                'parent_id' => NULL,
            ],
            [
                'name' => 'MakeUp',
                'parent_id' => 1,
            ],
            [
                'name' => 'Perfum',
                'parent_id' => 1,
            ],
            [
                'name' => 'SkinCare',
                'parent_id' => 1,
            ],
            [
                'name' => 'Eyelash',
                'parent_id' => 2,
            ],
            [
                'name' => 'Concealer',
                'parent_id' => 2,
            ],
            [
                'name' => 'EyeBrow',
                'parent_id' => 2,
            ],
            [
                'name' => 'Mascara',
                'parent_id' => 2,
            ],
            [
                'name' => 'Curling',
                'parent_id' => 8,
            ],
            [
                'name' => 'Lash',
                'parent_id' => 8,
            ],
            [
                'name' => 'Non-Clumbing',
                'parent_id' => 8,
            ],
            [
                'name' => 'Mink',
                'parent_id' => 5,
            ],
            [
                'name' => 'Sable',
                'parent_id' => 5,
            ],
            [
                'name' => 'eau de parfum',
                'parent_id' => 3,
            ],
            [
                'name' => 'eau de toilette',
                'parent_id' => 3,
            ],
            [
                'name' => 'eau de cologne',
                'parent_id' => 3,
            ],
            [
                'name' => 'mini Mink',
                'parent_id' => 12,
            ],
            [
                'name' => 'natural Mink',
                'parent_id' => 12,
            ],
            [
                'name' => 'Clothes',
                'parent_id' => NULL,
            ],
            
        ]);
    }
}
