<?php

namespace App\Http\Apis\v1\Product;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Tests\TestCase;

class ProductSearchControllerTest extends TestCase
{
    public function testReturnAnExistentProduct(): void
    {
        // Set
        $product = $this->instance(ProductRepository::class, m::mock(ProductRepository::class));
        $realProduct = new Product();
        $realProduct->name = 'Pizza';
        $expected = [
            'data' => [
                [
                    'name' => 'Pizza',
                    'description' => null,
                    'price' => null,
                    'image' => null,
                    'status' => null,
                    'stock' => null,
                    'validate' => null,
                    'ingredients' => null,
                ],
                [
                    'name' => 'Pizza',
                    'description' => null,
                    'price' => null,
                    'image' => null,
                    'status' => null,
                    'stock' => null,
                    'validate' => null,
                    'ingredients' => null,
                ],
            ]
        ];

      $collection = new Collection([$realProduct,$realProduct]);

        // Expectations
        $product->expects()
            ->findProductByName('pizza')
            ->andReturn($collection);

        // Action
        $actual = $this->post('http://localhost:8000/api/productSearch/?term=pizza');

        // Assertions
        $this->assertSame($expected, json_decode($actual->getContent(),1));
        $this->assertSame(200, $actual->getStatusCode());

    }

    public function testNotReturnAnExistentProduct(): void
    {
        // Set
        $product = $this->instance(ProductRepository::class, m::mock(ProductRepository::class));
        $expected = [
            'data' => []
        ];

        $collection = new Collection();

        // Expectations
        $product->expects()
            ->findProductByName('pizza')
            ->andReturn($collection);

        // Action
        $actual = $this->post('http://localhost:8000/api/productSearch/?term=pizza');

        // Assertions
        $this->assertSame(json_encode($expected), $actual->getContent());
        $this->assertSame(200, $actual->getStatusCode());
    }
}
