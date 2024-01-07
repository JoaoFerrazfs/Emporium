<?php

namespace Tests\Unit\App\Http\Checkout\DataTransferObject;

use App\Http\Controllers\Checkout\DataTransferObject\OrderFactory;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;
use DateTime;
use Exception;
use Mockery as m;
use Tests\TestCase;

class OrderFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testShouldBuildADTO(): void
    {
        // Set
        Carbon::setTestNow('01/01/2024');
        $orderFactory = new OrderFactory();
        $orderData = [
            'city' => 'BH',
            'street' => 'amazonas',
            'number' => 1250,
            'neighborhood' => 'centro',
            'observation' => 'some observation',
            'pickUpInStore' => 1,
        ];
        $address = [
            'city' => 'BH',
            'street' => 'amazonas',
            'number' => 1250,
            'neighborhood' => 'centro',
        ];
        $products = [
            'products' => [
                'product' => 'Product A',
                'quantity' => 2,
                'price' => 19.99,
            ],
            'total' => 100,
        ];
        $userData = [
            'name' => 'userName',
            'email' => 'useremail@gmail.com',
            'phone' => '99 99999999',
        ];

        $order = m::mock(Order::class)->makePartial()->fill($orderData);
        $order->id = 1;

        $user = $this->makeUser();
        $cart = $this->makeCart();

        // Actions
        $order->expects()
            ->getAttribute('user')
            ->andReturn($user);

        $order->expects()
            ->getAttribute('cart')
            ->andReturn($cart);

        $actual = $orderFactory->make($order);

        // Assertions
        $this->assertSame(1, $actual->id);
        $this->assertSame($address, $actual->address);
        $this->assertSame('some observation', $actual->observation);
        $this->assertSame(true, $actual->pickUpInStore);
        $this->assertSame($userData, $actual->user);
        $this->assertSame($products['products'], $actual->cart['products']);
        $this->assertSame($products['total'], $actual->cart['total']);
    }

    private function makeUser(): User
    {
        return new User([
            'name' => 'userName',
            'email' => 'useremail@gmail.com',
            'phone' => '99 99999999'
        ]);
    }

    private function makeCart(): Cart
    {
        return new Cart([
            'products' => '{"product": "Product A", "quantity": 2, "price": 19.99}',
            'total' => 100,
            'createdAt' => new DateTime('12/12/2023'),
        ]);
    }
}
