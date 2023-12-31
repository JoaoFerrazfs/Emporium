<?php

namespace Tests\Unit\App\Http\Checkout\DataTransferObject;

use App\Http\Controllers\Checkout\DataTransferObject\OrderDTO;
use DateTime;
use Tests\TestCase;

class OrderDTOTest extends TestCase
{
    public function testShouldReturnAnOrderDTO(): void
    {
        // Set
        $order = $this->getOrderData();

        // Action
        $actual = OrderDTO::buildFromArray($order);

        // Assertion
        $this->assertInstanceOf(OrderDTO::class, $actual);
    }

    private function getOrderData(): array
    {
        return [
            'id' => 1,
            'address' => [
                'street' => '123 Main St',
                'city' => 'Example City',
                'zipcode' => '12345',
            ],
            'observation' => 'This is a sample observation.',
            'pickUpInStore' => true,
            'createdAt' => new DateTime('2023-01-01 12:00:00'),
            'user' => [
                'id' => 100,
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ],
            'cart' => [
                [
                    'product' => 'Product A',
                    'quantity' => 2,
                    'price' => 19.99,
                ],
                [
                    'product' => 'Product B',
                    'quantity' => 1,
                    'price' => 29.99,
                ],
            ],
        ];
    }
}
