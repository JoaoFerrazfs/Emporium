<?php

namespace Admin\reports\products;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Tests\TestCase;

class ProcessorTest extends TestCase
{
    public function testShouldProcess():void
    {
        // Set
        $attributes = [
            'name' => 'pizza',
            'description' => 'something',
            'price' => '25',
            'status' => 'Ativo',
            'stock' => 8,
            'validate' => 25/10/9999,
            'ingredients' => 'everything'
        ];
        $expectation = [[
           'name',
           'description',
           'price',
           'status',
           'stock',
           'validate',
            'ingredients',
        ], array_values($attributes)];
        $product =  m::mock(Product::class);
        $collection = new Collection([$product]);
        $processor = new Processor();

        // Expectation
        $product->expects()
            ->getAttributes()
            ->andReturn($attributes);

        // Action
        $actual = $processor->process($collection);

        // Assertion
        $this->assertSame($expectation, $actual);
    }

    public function testShouldNotProcess():void
    {
        // Set
        $collection = new Collection([]);
        $processor = new Processor();

        // Action
        $actual = $processor->process($collection);

        // Assertion
        $this->assertNull($actual);
    }
}
