<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
  
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'description' => $this->faker->paragraph(),
            'price' =>$this->faker->numberBetween(100,300),
            'image' =>$this->faker->text
        ];
    }
}
