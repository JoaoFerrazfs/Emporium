<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Mockery as m;

class ProductRepositoryTest extends TestCase
{
    public function testShouldGetAllProducts(): void
    {
        // Set
        $product = $this->makeProduct();
        $collection = new Collection([$product]);

        $productRepository = new ProductRepository($product);

        // Expectation
        $product->expects()
            ->all()
            ->andReturn($collection);

        // Action
        $actual = $productRepository->getAllProducts();

        // Assertions
        $this->isInstanceOf(Collection::class);
        $this->assertSame($this->getExpectation(), $actual->first()->getAttributes());
    }
    public function testShouldFindProductsByTerm(): void
    {
        // Set
        $product = $this->makeProduct();

        $productRepository = new ProductRepository($product);

        // Expectation
        $product->expects()
            ->where('name', 'LIKE', '%pizza%')
            ->andReturnSelf();

        $product->expects()
            ->get()
            ->andReturn(new Collection([$product]));

        // Action
        $actual = $productRepository->findProductByName('pizza');

        // Assertions
        $this->isInstanceOf(Collection::class);
        $this->assertSame($this->getExpectation(), $actual->first()->getAttributes());
    }

    public function testShouldFindAvailableProductsByTerm(): void
    {
        // Set
        $product = $this->makeProduct();

        $productRepository = new ProductRepository($product);

        // Expectation
        $product->expects()
            ->where('name', 'LIKE', '%pizza%')
            ->andReturnSelf();

        $product->expects()
            ->where('status', 'disponivel')
            ->andReturnSelf();

        $product->expects()
            ->get()
            ->andReturn(new Collection([$product]));

        // Action
        $actual = $productRepository->findAvailableProductByName('pizza');

        // Assertions
        $this->isInstanceOf(Collection::class);
        $this->assertSame($this->getExpectation(), $actual->first()->getAttributes());
    }

    public function testShouldReturnAllAvailableProducts(): void
    {
        // Set
        $product = $this->makeProduct();
        $productRepository = new ProductRepository($product);

        // Expectation
        $product->expects()
            ->where('status', 'disponivel')
            ->andReturnSelf();

        $product->expects()
            ->get()
            ->andReturn(new Collection([$product]));

        // Action
        $actual = $productRepository->findAllAvailableProducts();

        // Assertions
        $this->isInstanceOf(Collection::class);
        $this->assertSame($this->getExpectation(), $actual->first()->getAttributes());
    }

    public function testShouldSaveAProduct(): void
    {
        // Set
        $product = $this->makeProduct();
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

        $productRepository = new ProductRepository($product);

        // Expectation
        $product->expects()
            ->create($input)
            ->andReturnTrue();

        // Action
        $actual = $productRepository->saveProduct($input);

        // Assertions
        $this->assertTrue($actual);
    }

    public function testShouldGetProduct(): void
    {
        // Set
        $product = $this->makeProduct();
        $productRepository = new ProductRepository($product);

        // Expectation
        $product->expects()
            ->find(10)
            ->andReturn($product);

        // Action
        $actual = $productRepository->first(10);

        // Assertions
        $this->assertInstanceOf(Product::class, $actual);
        $this->assertSame($product->getAttributes(), $actual->getAttributes());
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

    private function getExpectation(): array
    {
        return [

            'name' => 'Pizza',
            'description' => 'Pizza promoção',
            'price' => 9.99,
            'image' => 'pizza1.jpg',
            'status' => 'disponivel',
            'stock' => 99,
            'validate' => '2023-06-11',
            'ingredients' => 'tudo e mais um pouco',

        ];
    }
}
