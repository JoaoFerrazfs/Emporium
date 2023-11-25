<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::factory()->create([
            'name' => 'Pizza',
            "image" => "pizza1.jpg"
        ]);

        Product::factory()->create([
            'name' => 'Pizza 2',
            "image" => "pizza2.png"
        ]);

        Product::factory()->create([
            'name' => 'Pizza 3',
            "image" => "pizza3.jpg"
        ]);

    }
}
