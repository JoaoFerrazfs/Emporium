<?php

namespace App\Http\Apis\v1\Product;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Mockery as m;

class ProductReportsControllerTest extends TestCase
{
    public function testShouldExportProductsExports(): void
    {
        // Set
        Queue::fake();
        $productRepository = m::mock(ProductRepository::class);
        $product =  m::mock(Product::class);
        $collection = new Collection([$product]);

        // Expectations
        $productRepository->expects()
            ->findAllAvailableProducts()
            ->andReturn($collection);

        $productReportsController = new ProductReportsController($productRepository);

        // Actions
        $actual = $productReportsController->exportProducts();

        // Assertions
        $this->assertStringContainsString("products_report_", $actual->content());
    }

    public function testShouldNotExportProductsExports(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $product =  m::mock(Product::class);
        $collection = new Collection([$product]);
        $productReportsController = new ProductReportsController($productRepository);

        // Expectations
        $productRepository->expects()
            ->findAllAvailableProducts()
            ->andReturn($collection);

        Queue::shouldReceive('connection')
            ->andThrow(new \Exception('error'));

        // Actions
        $actual = $productReportsController->exportProducts();

        // Assertions
        $this->assertStringContainsString("error", $actual->content());
    }
}
