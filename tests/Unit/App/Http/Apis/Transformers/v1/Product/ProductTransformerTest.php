<?php

namespace App\Http\Apis\Transformers\v1\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ProductTransformerTest extends TestCase
{
    public function testShouldTransformProduct(): void
    {
        // Set
        $transformer =  new ProductTransformer();
        $product = $this->makeProduct();
        $expected = $this->getExpectation();

        $collection = new Collection([$product]);

        // Action
        $transformedProduct =   $transformer->transform($collection);

        // Assertions
        $this->assertSame($expected, $transformedProduct);
    }

    private function makeProduct(): Product
    {
        $product = new Product();
        $product->fill([
            'name' => 'Pizza',
            'description' => 'Pizza promoção',
            'price' => 9.99,
            'image' => 'pizza1.jpg',
            'status' => 'disponivel',
            'stock' => 99,
            'validate' => '2023-06-11',
            'ingredients' => 'tudo e mais um pouco'
        ]);

        return  $product;
    }

    private function getExpectation(): array
    {
        return  [
            [
                'name' => 'Pizza',
                'description' => 'Pizza promoção',
                'price' => 9.99,
                'image' => 'pizza1.jpg',
                'status' => 'disponivel',
                'stock' => 99,
                'validate' => '2023-06-11',
                'ingredients' => 'tudo e mais um pouco',
            ]
        ];
    }
}
