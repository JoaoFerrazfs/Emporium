<?php

namespace Test\Integration\App\Http\Apis\v1\Product;

use App\Http\Apis\v1\Product\ProductController;
use App\Http\Requests\Products\ProductsRequest;
use App\Models\Product;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->migrateFreshUsing();
        $this->withoutMiddleware();

        Carbon::setTestNow(new DateTime('01-02-2023'));
    }

    public function testShouldRegisterAProduct(): void
    {
        // Set
        $body = [
            "name" => "product name",
            "description" => "product description",
            "ingredients" => "product ingredients",
            "stock" => 199,
            "validate" => "01-01-9999",
            "price" => "9.99",
        ];
        $request = new ProductsRequest($body);
        $productController = $this->app->make(ProductController::class);

        // Actions
        $actual = $productController->store($request);

         // Assertions
        $this->assertSame(200, $actual->getStatusCode());
        $this->assertSame($this->getExpectedData(), json_decode($actual->getContent(), true));
    }

    public function testShouldReturnProducts(): void
    {
        // Set
        $this->persistProduct();
        $productController = $this->app->make(ProductController::class);

        // Actions
        $actual =$productController->listAvailableProducts();

         // Assertions
        $this->assertSame(200, $actual->getStatusCode());
        $this->assertSame($this->getExpectedList(), $actual->getOriginalContent());
    }

    public function testShouldReturnAProduct(): void
    {
        // Set
        $this->persistProduct();
        $productController = $this->app->make(ProductController::class);

        // Actions
        $actual =$productController->getProductById(1);

        // Assertions
        $this->assertSame(200, $actual->getStatusCode());
        $this->assertSame($this->getExpectedList(), $actual->getOriginalContent());
    }

    private function persistProduct(): void
    {
        Product::create([
            "name" => "product name",
            "description" => "product description",
            "ingredients" => "product ingredients",
            "stock" => 199,
            "validate" => "01-01-9999",
            "price" => "9.99",
            'image' => 'default.jpg',
            'status' => 'disponivel',
        ]);
    }

    private function getExpectedList(): array
    {
        return [
            'data' => [
                [
                    'name' => 'product name',
                    'description' => 'product description',
                    'price' => 9.99,
                    'image' => 'default.jpg',
                    'status' => 'disponivel',
                    'stock' => 199.0,
                    'validate' => '01-01-9999',
                    'ingredients' => 'product ingredients',
                ],
            ],
        ];
    }

    private function getExpectedData(): array
    {
            return [
                'data' => [
                    'product' => [
                        'name' => 'product name',
                        'description' => 'product description',
                        'ingredients' => 'product ingredients',
                        'stock' => 199,
                        'validate' => '01-01-9999',
                        'price' => '9.99',
                        'status' => 'indisponivel',
                        'image' => 'default.jpg',
                        'updated_at' => '2023-02-01T00:00:00.000000Z',
                        'created_at' => '2023-02-01T00:00:00.000000Z',
                        'id' => 1,
                    ]
                ],
            ];
    }
}
