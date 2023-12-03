<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Requests\Products\ProductsRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery as m;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function testShouldRegisterAProduct(): void
    {
        // Set
        $request = m::mock(ProductsRequest::class);
        $productRepository = m::mock(ProductRepository::class);
        $productController = new ProductController($productRepository);
        $image = UploadedFile::fake()->image('image-fake');

        $input = [
            'name' => 'Bolo de pizza',
            'description' => 'Bolo top dos tops',
            'ingredients' => 'Farinha e leite',
            'stock' => 199,
            'validate' => '28-12-2024',
            'price' => 9.99,
            'status' => 'Ativo',
            'image' => $image,
        ];

        // Expectations
        $request->expects()
            ->all()
            ->times(10)
            ->andReturn($input);

        $request->expects()
            ->hasFile('image')
            ->andReturnTrue();

        $request->expects()
            ->file('image')
            ->andReturn($image);

        $productRepository->expects()
            ->saveProduct(m::type('array'))
            ->andReturn(new Product());

        // Actions
        $actual = $productController->store($request);

        // Assertions

        $this->assertSame(200, $actual->getStatusCode());

    }

    public function testShouldNotRegisterAProduct(): void
    {
        // Set
        $request = m::mock(ProductsRequest::class);
        $productRepository = m::mock(ProductRepository::class);
        $productController = new ProductController($productRepository);
        Storage::fake();
        $errorMessage = 'Error when trying to register a new product';
        $image = UploadedFile::fake()->image('image-fake');

        $input = [
            'name' => 'Bolo de pizza',
            'description' => 'Bolo top dos tops',
            'ingredients' => 'Farinha e leite',
            'stock' => 199,
            'validate' => '28-12-2024',
            'price' => 9.99,
            'status' => 'Ativo',
            'image' => $image,
        ];

        // Expectations
        $request->expects()
            ->all()
            ->times(10)
            ->andReturn($input);

        $request->expects()
            ->hasFile('image')
            ->andReturnTrue();

        $request->expects()
            ->file('image')
            ->andReturn($image);

        $productRepository->expects()
            ->saveProduct(m::type('array'))
            ->andReturnNull();

        // Actions
        $actual = $productController->store($request);

        // Assertions
        $this->assertSame(500, $actual->getStatusCode());
        $this->assertStringContainsString($errorMessage, $actual->content());

    }
}

