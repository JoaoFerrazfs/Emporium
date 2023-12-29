<?php

namespace Test\Integration\App\Http\Apis\v1\Product;

use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldRegisterAProduct(): void
    {
        // Set
        $this->migrateFreshUsing();

        Carbon::setTestNow(new DateTime('01-02-2023'));

        $body = [
            "name" => "product name",
            "description" => "product description",
            "ingredients" => "product ingredients",
            "stock" => 199,
            "validate" => "01-01-9999",
            "price" => "9.99",
        ];

        // Actions
        $actual = $this->postJson(
            '/api/v1/products/admin',
            $body
        );

         // Assertions
        $this->assertSame(200, $actual->getStatusCode());
        $this->assertSame($this->getExpectedData(), json_decode($actual->getContent(), true));
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
