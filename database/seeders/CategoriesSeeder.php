<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::create([
            'name' => 'Electronics',
            'description' => 'Devices and gadgets designed for everyday convenience, from smartphones to home appliances.'
        ]);

        Categories::create([
            'name' => 'Furniture',
            'description' => 'High-quality, durable furniture for modern homes and offices, including tables, chairs, and desks.'
        ]);

        Categories::create([
            'name' => 'Clothing',
            'description' => 'Trendy and comfortable clothing items for all ages, made with sustainable and eco-friendly materials.'
        ]);

        Categories::create([
            'name' => 'Books',
            'description' => 'A curated selection of novels, educational books, and reference materials for avid readers.'
        ]);

        Categories::create([
            'name' => 'Sports Equipment',
            'description' => 'Gear and accessories for various sports, ideal for beginners and professionals alike.'
        ]);

        Categories::create([
            'name' => 'Beauty Products',
            'description' => 'Cosmetics and skincare items, formulated with natural ingredients for a radiant complexion.'
        ]);
    }
}
