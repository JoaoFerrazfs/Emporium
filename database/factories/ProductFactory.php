<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            "name" => "Pizza",
            "description" => "Pizza promoção",
            "ingredients" => "tudo e mais um pouco",
            "stock" => "99",
            "validate" => "2023-06-11",
            "price" => "9.99",
            "status" => "disponivel",
            "image" => "default.jpg",
        ];
    }
}
