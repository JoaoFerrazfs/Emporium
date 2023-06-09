<?php

namespace Tests\Unit;

use App\Models\Product;

use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;

use Mockery as m;

class ProductSearchControllerTest extends TestCase
{
    public function testReturnAnExistentProduct(): void
    {
        // Set
        $product = $this->instance(Product::class, m::mock(Product::class)->makePartial());
        $realProduct = new Product();
        $realProduct->name = 'Pizza';
        $expected = '{"data":[{"name":"Pizza"},{"name":"Pizza"}]}';

        $builder = m::mock(Builder::class);

        // Expectations
        $product->expects()
            ->where()
            ->withAnyArgs()
            ->andReturn($builder);

        $builder->expects()
            ->get()
            ->andReturn(collect([$realProduct,$realProduct]));

        // Action
        $actual =$this->post('http://localhost:8000/api/productSearch/?term=pizza');

        // Assertions
        $this->assertSame($expected, $actual->getContent());
        $this->assertSame(200, $actual->getStatusCode());

    }

    public function testNotReturnAnExistentProduct(): void
    {
        // Set
        $product = $this->instance(Product::class, m::mock(Product::class)->makePartial());
        $realProduct = new Product();
        $expected = '{"data":[]}';

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
        $actual =$this->post('http://localhost:8000/api/productSearch/?term=pizza');

        // Assertions
        $this->assertSame($expected, $actual->getContent());
        $this->assertSame(200, $actual->getStatusCode());
    }
}
