<?php

namespace Test\App\Http\Apis\Requests\V1\Products;

use App\Http\Apis\Requests\v1\Products\ProductRequest;
use Tests\TestCase;

class ProductRequestTest extends TestCase
{
    public function testShouldReturnRules(): void
    {
        // Set
        $expected = ['term' => 'required|min:3'];
        $authLoginRequest = new ProductRequest();

        // Action
        $actual = $authLoginRequest->rules();

        // Assertions
        $this->assertSame($expected, $actual);

    }
}
