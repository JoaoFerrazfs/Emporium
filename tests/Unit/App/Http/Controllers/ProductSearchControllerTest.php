<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Mockery as m;
use Illuminate\Support\Facades\Route;

class ProductSearchControllerTest extends TestCase
{
    public function testShouldFindProductsByTerm(): void
    {
        // Set
        Route::get('/',[ProductController::class,'viewProduct'])->name('product.page');


        $product = $this->instance(ProductRepository::class, m::mock(ProductRepository::class));
        $realProduct = $this->makeProduct();
        $collection = new Collection([$realProduct]);

        // Expectations
        $product->expects()
            ->findAvailableProductByName('pizza')
            ->andReturn($collection);

        // Action
        $actual = $this->get('http://localhost:8000/produtos/pesquisa?search_term=pizza');
        // Assertions

        $actual->assertViewHas('products');
        $actual->assertViewIs('ecommerce.products.productsList');

    }

    private function makeProduct(): Product
    {
        $product = m::mock(Product::class)->makePartial();
        $product->fill([
            'name' => 'Pizza',
            'description' => 'Pizza promoção',
            'price' => 9.99,
            'image' => 'pizza1.jpg',
            'status' => 'disponivel',
            'stock' => 99,
            'validate' => '2023-06-11',
            'ingredients' => 'tudo e mais um pouco'
        ]);

        $product->id = 10;

        return $product;
    }
}
