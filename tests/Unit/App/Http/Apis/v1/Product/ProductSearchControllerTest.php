<?php

namespace App\Http\Apis\v1\Product;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Apis\Requests\v1\Products\ProductRequest;
use App\Http\Apis\Transformers\v1\Product\ProductTransformer;
use Mockery as m;
use Tests\TestCase;

class ProductSearchControllerTest extends TestCase
{
    public function testShouldReturnAnExistentProduct(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $productTransfomer = m::mock(ProductTransformer::class);
        $request = m::mock(ProductRequest::class);
        $ProductSearchController = new ProductSearchController($productRepository, $productTransfomer);
        $realProduct = new Product();
        $realProduct->name = 'Pizza';
        $expected = $this->getExpectedResponse() ;

        $collection = new Collection([$realProduct,$realProduct]);

        // Expectations
        $request->expects()
            ->get('term')
            ->andReturn('pizza');

        $productRepository->expects()
            ->findProductByName('pizza')
            ->andReturn($collection);

        $productTransfomer->expects()
            ->transform($collection)
            ->andReturn($expected);

        // Action
        $actual = $ProductSearchController->search($request);

        // Assertions
        $this->assertSame(200, $actual->getStatusCode());

    }

    public function testShouldNotReturnAnExistentProduct(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $productTransfomer = m::mock(ProductTransformer::class);
        $request = m::mock(ProductRequest::class);
        $ProductSearchController = new ProductSearchController($productRepository, $productTransfomer);

        // Expectations
        $request->expects()
            ->get('term')
            ->andReturn('pizza');

        $productRepository->expects()
            ->findProductByName('pizza')
            ->andReturnNull();

        // Action
        $actual = $ProductSearchController->search($request);

        // Assertions
        $this->assertSame(404, $actual->status());
    }

    private function getExpectedResponse(): array
    {
        return [
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
    }
}
