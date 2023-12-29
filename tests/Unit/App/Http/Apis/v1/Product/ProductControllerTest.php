<?php

namespace App\Http\Apis\v1\Product;

use App\Http\Apis\Transformers\v1\Product\ProductTransformer;
use App\Http\Requests\Products\ProductsRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
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
        $productTransformer = m::mock(ProductTransformer::class);
        $productController = new ProductController($productRepository, $productTransformer);
        $image = $this->createImage();

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
        $productTransformer = m::mock(ProductTransformer::class);
        $productController = new ProductController($productRepository, $productTransformer);
        Storage::fake();
        $errorMessage = 'Error when trying to register a new product';
        $image = $this->createImage();

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

    public function testShouldNotReturnAnListOfProducts(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);
        $productController = new ProductController($productRepository, $productTransformer);
        $realProduct = new Product();
        $realProduct->name = 'Pizza';

        // Expectations
        $productRepository->expects()
            ->findAllAvailableProducts()
            ->andReturn();

        // Action
        $actual = $productController->listAvailableProducts();

        // Assertions
        $this->assertSame(404, $actual->getStatusCode());
    }

    public function testShouldReturnAnListOfProducts(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);
        $productController = new ProductController($productRepository, $productTransformer);
        $realProduct = new Product();
        $realProduct->name = 'Pizza';
        $expected = $this->getExpectedResponse() ;

        $collection = new Collection([$realProduct,$realProduct]);

        // Expectations
        $productRepository->expects()
            ->findAllAvailableProducts()
            ->andReturn($collection);

        $productTransformer->expects()
            ->transform($collection)
            ->andReturn($expected);

        // Action
        $actual = $productController->listAvailableProducts();

        // Assertions
        $this->assertSame(200, $actual->getStatusCode());
    }

    public function testShouldGetProductById(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);
        $productController = new ProductController($productRepository, $productTransformer);
        $product = new Product(['status' => 'disponivel']);

        // Expectations
        $productRepository->expects()
            ->first('55')
            ->andReturn($product);

        $productTransformer->expects()
            ->transform(m::type(Collection::class))
            ->andReturn([]);

        // Action
        $actual = $productController->getProductById('55');

        // Assertions
        $this->assertSame(200, $actual->getStatusCode());
    }

    public function testShouldNotGetNoxExistProductById(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);
        $productController = new ProductController($productRepository, $productTransformer);

        // Expectations
        $productRepository->expects()
            ->first('55')
            ->andReturnNull();

        // Action
        $actual = $productController->getProductById('55');

        // Assertions
        $this->assertSame(404, $actual->getStatusCode());
    }

    private function getExpectedResponse(): array
    {
        $product =  [
            'name' => 'Pizza',
            'description' => null,
            'price' => null,
            'image' => null,
            'status' => null,
            'stock' => null,
            'validate' => null,
            'ingredients' => null,
        ];

        return [
            'data' => [
                $product,
                $product,
            ]
        ];
    }

    private function createImage(): UploadedFile
    {
        $imagePath = storage_path('../tests/assets/images/logo.jpg');
        return new UploadedFile(
            $imagePath,
            'image-fake.jpg',
            'image/jpeg',
            null,
            true
        );
    }
}
