<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttributes>
 */
class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Products::inRandomOrder()->first()->id,
            'name' => fake()->randomElement(['Color', 'Size', 'Material', 'Weight', 'Dimensions']),
            'value' => fake()->unique()->randomElement([
                'Red', 'Blue', 'Green', 'Small', 'Medium', 'Large', 
                'Cotton', 'Leather', 'Wood', '1kg', '2kg', '30x20x10 cm'
            ]),
        ];
    }
}
