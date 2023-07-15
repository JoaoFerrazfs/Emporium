<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Tests\TestCase;
use Mockery as m;

class ProductSearchControllerTest extends TestCase
{
    public function testShouldFindProductsByTerm(): void
    {
        // Set
        $product = $this->instance(ProductRepository::class, m::mock(ProductRepository::class));
        $realProduct = $this->makeProduct();
        $collection = new Collection([$realProduct]);
        $request = m::mock(Request::class);

        $productSearchController = new ProductSearchController($product);

        // Expectations
        $product->expects()
            ->findAvailableProductByName('pizza')
            ->andReturn($collection);

        $request->expects()
            ->get('search_term', false)
            ->andReturn('pizza');

        // Action
        $actual = $productSearchController->getProducts($request);

        // Assertions
        $this->isInstanceOf(View::class);

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

        $product->id = 10;

        return $product;
    }
}
