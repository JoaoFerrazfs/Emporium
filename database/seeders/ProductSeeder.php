<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $i = 0;
        while ($i < 50) {
            Product::factory()->create([
                'name' => 'Pizza',
                "description" => "Nova pizza $i",
                "price" => $i * random_int(0, 20),
                "image" => "pizza$i.jpg",
                "status" => "Ativo",
                "stock" => $i * random_int(0, 5),
                "validate" => new \DateTime('+ 50 days')
            ]);

            $i++;
        }
    }
}
