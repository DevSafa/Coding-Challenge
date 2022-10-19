<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /* define a model property on the corresponding factory */
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    /** The definition method returns the default set of attribute 
     * values that should be applied when creating a model 
     * using the factory. */
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
