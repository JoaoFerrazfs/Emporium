<?php

namespace App\Http\Controllers;

use Admin\contents\Image;
use App\Http\Requests\Products\ProductsRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Mockery as m;

class ProductControllerTest extends TestCase
{
    public function testShouldCreateNewProduct(): void
    {
        // Set
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
        $request = m::mock(ProductsRequest::class);
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

        $product = new ProductController($image, $productRepository);

        // Expectations
        $request->expects()
            ->all()
            ->andReturn($input);

        $image->expects()
            ->saveLocalImage($request)
            ->andReturn('/anyImage');

        $productRepository->expects()
            ->saveProduct($input)
            ->andReturnTrue();

        // Actions
        $actual = $product->store($request);

        // Assertions
        $this->assertNotEmpty($actual->getData());
        $this->assertSame('admin.products.productsList', $actual->name());
    }

    public function testShouldNoCreateNewProduct(): void
    {
        // Set
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
        $request = m::mock(ProductsRequest::class);
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

        $product = new ProductController($image, $productRepository);

        // Expectations
        $request->expects()
            ->all()
            ->andReturn($input);

        $image->expects()
            ->saveLocalImage($request)
            ->andReturn('/anyImage');

        $productRepository->expects()
            ->saveProduct($input)
            ->andReturnFalse();

        // Actions
        $actual = $product->store($request);
        // Assertions
        $this->assertNotEmpty($actual->getData());
        $this->assertSame('admin.products.productsList', $actual->name());
        $this->assertSame('Erro ao cadastrar produto', $actual->getData()['msg']);
    }

    public function testShouldReturnAPageWithProducts(): void
    {
        // Set
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
        $product = $this->makeProduct();
        $productCollection = new Collection([$product]);

        $productController = new ProductController($image, $productRepository);

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
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
        $product = $this->makeProduct();
        $productCollection = new Collection([$product]);

        $productController = new ProductController($image, $productRepository);

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
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
        $product = $this->makeProduct();

        $productController = new ProductController($image, $productRepository);

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

    public function testShouldReturnAPageWithOneProduct(): void
    {
        // Set
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
        $product = $this->makeProduct();

        $productController = new ProductController($image, $productRepository);

        // Expectations
        $productRepository->expects()
            ->first(10)
            ->andReturn($product);

        // Actions
        $actual = $productController->editProducts('10');

        // Assertions
        $this->assertInstanceOf(Product::class, $actual->getData()['product']);
        $this->assertSame($product->getAttributes(), $actual->getData()['product']->getAttributes());
    }

    public function testShouldUpdateProduct(): void
    {
        // Set
        Route::post('/produtos/salvarEdicao', [ProductController::class, 'update'])->name('admin.products.update');
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
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

        $productController = new ProductController($image, $productRepository);

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

        $image->expects()
            ->saveLocalImage($request)
            ->andReturn('/anyImage');

        $product->expects()
            ->update($input)
            ->andReturnTrue();

        // Action
        $actual = $productController->update($request);

        // Assertions
        $this->assertSame('admin.products.productsList', $actual->name());
        $this->assertNull($actual->getData()['msg'] ?? null);
    }

    public function testShouldNotUpdateProduct(): void
    {
        // Set
        Route::post('/produtos/salvarEdicao', [ProductController::class, 'update'])->name('admin.products.update');
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
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

        $productController = new ProductController($image, $productRepository);

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

        $image->expects()
            ->saveLocalImage($request)
            ->andReturn('/anyImage');

        $product->expects()
            ->update($input)
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
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
        $product = m::mock(Product::class);

        $productController = new ProductController($image, $productRepository);

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
        $image = m::mock(Image::class);
        $productRepository = m::mock(ProductRepository::class);
        $product = m::mock(Product::class);

        $productController = new ProductController($image, $productRepository);

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
