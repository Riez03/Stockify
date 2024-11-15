<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Categories::inRandomOrder()->first()->id,
            'supplier_id' => Suppliers::inRandomOrder()->first()->id,
            'name' => $this->faker->word,
            'sku' => $this->faker->unique()->bothify('??#####'),
            'description' => $this->faker->sentence,
            'purchase_price' => $this->faker->randomFloat(2, 10, 1000),
            'selling_price' => $this->faker->randomFloat(2, 20, 2000),
            'image' => $this->faker->imageUrl(640, 480, 'product', true, 'example'),
        ];
    }
}
