<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductsRequest;
use App\Http\Transformers\Product as ProductTransformer;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Mockery as m;

class ProductControllerTest extends TestCase
{
    public function testShouldStoreNewProduct(): void
    {
        // Set
        $productTransformer = m::mock(ProductTransformer::class);
        $productRepository = m::mock(ProductRepository::class);
        $request = m::mock(ProductsRequest::class);
        Storage::fake()->append('bolo.jpg', 'sas');
        $uploadedFile = UploadedFile::fake();
        $file = $uploadedFile->image('bolo.jpg', 5, 5);
        $input = [
            'name' => 'Bolo',
            'description' => 'Bolo doce',
            'ingredients' => 'Coco',
            'stock' => 90,
            'validate' => '23/04/2023',
            'price' => '90',
            'status' => 'disponivel',
            'image' => $file
        ];

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectations
        $request->expects()
            ->all()
            ->times(3)
            ->andReturn($input);

        $request->expects()
            ->hasFile('image')
            ->andReturnTrue();

        $request->expects()
            ->file('image')
            ->andReturn($file->getPathname());

        $productRepository->expects()
            ->saveProduct(m::type('array'))
            ->andReturnTrue();

        $productRepository->expects()
            ->getAllProducts()
            ->andReturn(new Collection([]));

        // Actions
        $actual = $productController->store($request);

        // Assertions
        $this->assertNotEmpty($actual->getData());
        $this->assertSame('admin.products.productsList', $actual->name());
    }

    public function testShouldNoCreateNewProduct(): void
    {
        // Set
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);
        $request = m::mock(ProductsRequest::class);
        Storage::fake()->append('bolo.jpg', 'sas');
        $uploadedFile = UploadedFile::fake();
        $file = $uploadedFile->image('bolo.jpg', 5, 5);
        $input = [
            'name' => 'Bolo',
            'description' => 'Bolo doce',
            'ingredients' => 'Coco',
            'stock' => 90,
            'validate' => '23/04/2023',
            'price' => '90',
            'status' => 'disponivel',
            'image' => $file
        ];

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectations
        $request->expects()
            ->all()
            ->andReturn($input);

        $request->expects()
            ->hasFile('image')
            ->andReturnFalse();

        $productRepository->expects()
            ->saveProduct(m::type('array'))
            ->andReturnFalse();

        $productRepository->expects()
            ->getAllProducts()
            ->andReturn(new Collection([]));

        // Actions
        $actual = $productController->store($request);

        // Assertions
        $this->assertNotEmpty($actual->getData());
        $this->assertSame('admin.products.productsList', $actual->name());
        $this->assertSame('Erro ao cadastrar produto', $actual->getData()['msg']);
    }

    public function testShouldReturnAPageWithProducts(): void
    {
        // Set
        $product = $this->makeProduct();
        $productCollection = new Collection([$product]);
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectations
        $productRepository->expects()
            ->getAllProducts()
            ->andReturn($productCollection);


        // Actions
        $actual = $productController->myProducts();

        // Assertions
        $this->assertInstanceOf(Collection::class, $actual->getData()['products']);
        $this->assertSame($product->getAttributes(), $actual->getData()['products']->first()->getAttributes());
    }

    public function testShouldReturnAHomeWithProducts(): void
    {
        // Set
        $product = $this->makeProduct();
        $productCollection = new Collection([$product]);
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectations
        $productRepository->expects()
            ->findAllAvailableProducts()
            ->andReturn($productCollection);


        // Actions
        $actual = $productController->index();

        // Assertions
        $this->assertInstanceOf(Collection::class, $actual->getData()['products']);
        $this->assertSame($product->getAttributes(), $actual->getData()['products']->first()->getAttributes());
        $this->assertSame('ecommerce.products.productsList', $actual->name());
    }

    public function testShouldReturnFilledProductPage(): void
    {
        // Set
        $product = $this->makeProduct();

        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectations
        $productRepository->expects()
            ->first(10)
            ->andReturn($product);

        // Actions
        $actual = $productController->viewProduct(10);

        // Assertions
        $this->assertInstanceOf(Product::class, $actual->getData()['product']);
        $this->assertSame($product->getAttributes(), $actual->getData()['product']->getAttributes());
        $this->assertSame('ecommerce.products.productPage', $actual->name());
    }

    public function testShouldReturnEditProductPage(): void
    {
        // Set
        $product = $this->makeProduct();
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectations
        $productRepository->expects()
            ->first(10)
            ->andReturn($product);

        $productTransformer->expects()
            ->transformProduct($product)
            ->andReturn([]);

        // Actions
        $actual = $productController->editProducts('10');

        // Assertions
        $this->assertArrayHasKey('product', $actual->getData());
        $this->assertSame('admin.products.productEdit', $actual->name());
    }

    public function testShouldNotReturnEditProductPage(): void
    {
        // Set
        $product = $this->makeProduct();
        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectations
        $productRepository->expects()
            ->first(10)
            ->andReturnNull();

        $productRepository->expects()
            ->getAllProducts()
            ->andReturn(new Collection($product));


        // Actions
        $actual = $productController->editProducts('10');

        // Assertions
        $this->assertSame('admin.products.productsList', $actual->name());
    }

    public function testShouldUpdateProduct(): void
    {
        // Set
        Route::post('/produtos/salvarEdicao', [ProductController::class, 'update'])->name('Admin.products.update');
        $request = m::mock(ProductsRequest::class);
        $product = $this->makeProduct();
        $productCollection = new Collection([$product]);
        $product = m::mock(Product::class);
        $input = [
            'name' => 'Bolo',
            'description' => 'Bolo doce',
            'ingredients' => 'Coco',
            'stock' => 90,
            'validate' => '23/04/2023',
            'price' => '90',
            'status' => 'disponivel',
            'image' => '/anyImage'
        ];

        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);
        $productController = new ProductController($productRepository, $productTransformer);

        // Expectation
        $request->expects()
            ->offsetGet('id')
            ->andReturn(10);

        $request->expects()
            ->all()
            ->andReturn($input);

        $productRepository->expects()
            ->first(10)
            ->andReturn($product);

        $productRepository->expects()
            ->getAllProducts()
            ->andReturn($productCollection);

        $request->expects()
            ->hasFile('image')
            ->andReturnFalse();

        $product->expects()
            ->update(m::type('array'))
            ->andReturnTrue();

        $product->expects()
            ->getAttribute('image')
            ->andReturn('path');

        // Action
        $actual = $productController->update($request);

        // Assertions
        $this->assertSame('admin.products.productsList', $actual->name());
        $this->assertNull($actual->getData()['msg'] ?? null);
    }

    public function testShouldNotUpdateProduct(): void
    {
        // Set
        Route::post('/produtos/salvarEdicao', [ProductController::class, 'update'])->name('Admin.products.update');
        $request = m::mock(ProductsRequest::class);
        $product = $this->makeProduct();
        $productCollection = new Collection([$product]);
        $product = m::mock(Product::class);
        $input = [
            'name' => 'Bolo',
            'description' => 'Bolo doce',
            'ingredients' => 'Coco',
            'stock' => 90,
            'validate' => '23/04/2023',
            'price' => '90',
            'status' => 'disponivel',
            'image' => '/anyImage'
        ];

        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);
        $productController = new ProductController($productRepository, $productTransformer);

        // Expectation
        $request->expects()
            ->offsetGet('id')
            ->andReturn(10);

        $request->expects()
            ->all()
            ->andReturn($input);

        $productRepository->expects()
            ->first(10)
            ->andReturn($product);

        $productRepository->expects()
            ->getAllProducts()
            ->andReturn($productCollection);

        $request->expects()
            ->hasFile('image')
            ->andReturnFalse();

        $product->expects()
            ->getAttribute('image')
            ->andReturnFalse();

        $product->expects()
            ->update(m::type('array'))
            ->andReturnFalse();


        // Action
        $actual = $productController->update($request);

        // Assertions
        $this->assertSame('admin.products.productsList', $actual->name());
        $this->assertSame('Erro ao cadastrar produto', $actual->getData()['msg']);
    }

    public function testShouldDeleteProduct(): void
    {
        // Set
        $product = m::mock(Product::class);

        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectation
        $productRepository->expects()
            ->first(10)
            ->andReturn($product);

        $productRepository->expects()
            ->getAllProducts()
            ->andReturn(new Collection([$product]));

        $product->expects()
            ->delete()
            ->andReturnTrue();

        // Action
        $actual = $productController->deleteProducts('10');

        // Assertions
        $this->assertSame('admin.products.productsList', $actual->name());
        $this->assertNull($actual->getData()['msg'] ?? null);
    }

    public function testShouldNoDeleteProduct(): void
    {
        // Set
        $product = m::mock(Product::class);

        $productRepository = m::mock(ProductRepository::class);
        $productTransformer = m::mock(ProductTransformer::class);

        $productController = new ProductController($productRepository, $productTransformer);

        // Expectation
        $productRepository->expects()
            ->first(10)
            ->andReturn($product);

        $productRepository->expects()
            ->getAllProducts()
            ->andReturn(new Collection([$product]));

        $product->expects()
            ->delete()
            ->andReturnFalse();

        // Action
        $actual = $productController->deleteProducts('10');

        // Assertions
        $this->assertSame('admin.products.productsList', $actual->name());
        $this->assertSame('Erro ao cadastrar produto', $actual->getData()['msg']);
    }

    private function makeProduct(): Product
    {
        $product = m::mock(Product::class)->makePartial();
        $product->fill(
            [
            'name' => 'Pizza',
            'description' => 'Pizza promoção',
            'price' => 9.99,
            'image' => 'pizza1.jpg',
            'status' => 'disponivel',
            'stock' => 99,
            'validate' => '2023-06-11',
            'ingredients' => 'tudo e mais um pouco'
            ]
        );

        return $product;
    }
}
