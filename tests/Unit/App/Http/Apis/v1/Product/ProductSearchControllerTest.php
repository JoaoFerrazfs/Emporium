<?php

namespace App\Http\Apis\v1\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;
use Tests\TestCase;

class ProductSearchControllerTest extends TestCase
{
    public function testReturnAnExistentProduct(): void
    {
        // Set
        $product = $this->instance(Product::class, m::mock(Product::class)->makePartial());
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

        $builder = m::mock(Builder::class);

        // Expectations
        $product->expects()
            ->where()
            ->withAnyArgs()
            ->andReturn($builder);

        $builder->expects()
            ->get()
            ->andReturn(collect([$realProduct, $realProduct]));

        // Action
        $actual = $this->post('http://localhost:8000/api/productSearch/?term=pizza');
        // Assertions
        $this->assertSame($expected, json_decode($actual->getContent(),1));
        $this->assertSame(200, $actual->getStatusCode());

    }

    public function testNotReturnAnExistentProduct(): void
    {
        // Set
        $product = $this->instance(Product::class, m::mock(Product::class)->makePartial());
        $realProduct = new Product();
        $expected = [
            'data' => []
        ];

        $builder = m::mock(Builder::class);

        // Expectations
        $product->expects()
            ->where()
            ->withAnyArgs()
            ->andReturn($builder);

        $builder->expects()
            ->get()
            ->andReturn(collect($realProduct));

        // Action
        $actual = $this->post('http://localhost:8000/api/productSearch/?term=pizza');

        // Assertions
        $this->assertSame(json_encode($expected), $actual->getContent());
        $this->assertSame(200, $actual->getStatusCode());
    }
}
