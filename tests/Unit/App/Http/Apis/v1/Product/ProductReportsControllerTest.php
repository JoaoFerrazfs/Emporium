<?php

namespace App\Http\Apis\v1\Product;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Mockery as m;

class ProductReportsControllerTest extends TestCase
{
    public function testShouldExportProducts(): void
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

    public function testShouldNotExportProducts(): void
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
            ->andThrow(new Exception('error'));

        // Actions
        $actual = $productReportsController->exportProducts();

        // Assertions
        $this->assertStringContainsString("error", $actual->content());
    }

    public function testShouldNotExportNonExistsProducts(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $productReportsController = new ProductReportsController($productRepository);

        // Expectations
        $productRepository->expects()
            ->findAllAvailableProducts()
            ->andReturnNull();

        Queue::shouldReceive('connection')
            ->andThrow(new Exception('error'));

        // Actions
        $actual = $productReportsController->exportProducts();

        // Assertions
        $this->assertEmpty($actual->getOriginalContent()['data']);
    }
}
