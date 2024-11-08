<?php

namespace Database\Seeders;

use App\Models\Suppliers;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Suppliers::factory(15)->create();
    }
}
