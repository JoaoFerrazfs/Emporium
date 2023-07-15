<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressRequest;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Mockery as m;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    public function testShouldReturnAViewWithOrders(): void
    {
        // Set
        $orderRepository = m::mock(OrderRepository::class);
        $orderController = new OrderController($orderRepository);
        $order = new Order();
        $order->fill($this->getOrderAttibutes());
        $order->id = 1;

        // Expectations
        $orderRepository->expects()
            ->getAllOrders()
            ->andReturn(new Collection([$order]));

        // Actions
        $actual = $orderController->index();

        // Assertions
        $this->assertSame('admin.orders.home', $actual->name());
        $order = $actual->getData()['orders'][0];
        $this->assertSame($this->getOrderAttibutes(), $order->getAttributes());
    }

    public function testShouldReturnAViewUserOrders(): void
    {
        // Set
        $request = m::mock(Request::class);
        $user = m::mock(User::class);
        $orderRepository = m::mock(OrderRepository::class);
        $orderController = new OrderController($orderRepository);
        $order = new Order();
        $order->fill($this->getOrderAttibutes());
        $order->id = 1;

        // Expectations
        $request->expects()
            ->user()
            ->andReturn($user);

        $user->expects()
            ->getAttribute('id')
            ->andReturn(1);

        $orderRepository->expects()
            ->getOrderById('1')
            ->andReturn(new Collection([$order]));

        // Actions
        $actual = $orderController->getUserOrders($request);

        // Assertions
        $this->assertSame('ecommerce.user.orders.orders', $actual->name());
        $order = $actual->getData()['orders'][0];
        $this->assertSame($this->getOrderAttibutes(), $order->getAttributes());
    }

    public function testShouldReturnAShoppingList(): void
    {
        // Set
        $request = m::mock(Request::class);
        $orderRepository = m::mock(OrderRepository::class);
        $orderController = new OrderController($orderRepository);

        $cart = [
            [
                "id" => 10,
                "name" => "Pizza",
                "description" => "Pizza promoção",
                "ingredients" => "tudo e mais um pouco",
                "price" => 9.99,
                "image" => "pizza1.jpg",
                "status" => "disponivel",
                "stock" => 99,
                "validate" => "2023-06-11",
                "created_at" => "2023-06-10T20:26:06.000000Z",
                "updated_at" => "2023-06-10T20:26:06.000000Z"
            ]
        ];

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturn(json_encode($cart));

        // Actions
        $actual = $orderController->showShoppingList($request);

        // Assertions
        $this->assertSame('ecommerce.checkout.cart', $actual->name());
        $this->assertEquals($cart, $actual->getData()['cart']);
    }

    public function testShouldReturnEmptyShoppingListPage(): void
    {
        // Set
        $request = m::mock(Request::class);
        $orderRepository = m::mock(OrderRepository::class);
        $orderController = new OrderController($orderRepository);

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturnNull();

        // Actions
        $actual = $orderController->showShoppingList($request);

        // Assertions
        $this->assertSame('ecommerce.checkout.emptyCart', $actual->name());
    }

    public function testShouldResolveOrderForGetRequisition(): void
    {
        // Set
        $request = m::mock(AddressRequest::class);
        $orderRepository = m::mock(OrderRepository::class);
        $orderController = new OrderController($orderRepository);
        $cart = [
            [
                "id" => 10,
                "name" => "Pizza",
                "description" => "Pizza promoção",
                "ingredients" => "tudo e mais um pouco",
                "price" => 9.99,
                "image" => "pizza1.jpg",
                "status" => "disponivel",
                "stock" => 99,
                "validate" => "2023-06-11",
                "created_at" => "2023-06-10T20:26:06.000000Z",
                "updated_at" => "2023-06-10T20:26:06.000000Z"
            ]
        ];
        $expected = [
            'user_id' => null,
            'zipCode' => '32920-000',
            'neighborhood' => 'Pedra Branca',
            'city' => 'Sao Joaquim de Bicas',
            'street' => 'Poços de Caldas',
            'number' => '26',
            'status' => 'Aguardando confirmacao',
            'completeCartItems' => [[
                'id' => 10,
                'quantity' => 1,
                'name' => 'Pizza',
                'price' => 9.99,
                'stock' => 99,
            ]],
            'total' => 9.99,
            'pickUpInStore' => true,
        ];

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturn(json_encode($cart));

        $request->expects()
            ->method()
            ->andReturn('GET');

        // Action
        $actual = $orderController->resolveOrder($request);

        // Assertions
        $this->assertSame('ecommerce.checkout.orderConfirmation', $actual->name());
        $this->assertEquals($expected, $actual->getData()['preparedOrder']);
    }

    public function testShouldResolveOrderForPostRequisition(): void
    {
        // Set
        $request = m::mock(AddressRequest::class);
        $orderRepository = m::mock(OrderRepository::class);
        $orderController = new OrderController($orderRepository);
        $cart = [
            [
                "id" => 10,
                "name" => "Pizza",
                "description" => "Pizza promoção",
                "ingredients" => "tudo e mais um pouco",
                "price" => 9.99,
                "image" => "pizza1.jpg",
                "status" => "disponivel",
                "stock" => 99,
                "validate" => "2023-06-11",
                "created_at" => "2023-06-10T20:26:06.000000Z",
                "updated_at" => "2023-06-10T20:26:06.000000Z"
            ]
        ];
        $expected = [
            'user_id' => null,
            'zipCode' => '32000-000',
            'neighborhood' => 'Vila Rica',
            'city' => 'São Joaquim de Bicas',
            'street' => 'Santa clara',
            'observation' => '',
            'number' => 160,
            'status' => 'Aguardando confirmacao',
            'completeCartItems' => [[
                'id' => 10,
                'quantity' => 1,
                'name' => 'Pizza',
                'price' => 9.99,
                'stock' => 99,
            ]],
            'total' => '16.99',
            'pickUpInStore' => false,
        ];

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturn(json_encode($cart));

        $request->expects()
            ->method()
            ->twice()
            ->andReturn('POST');

        $request->expects()
            ->all()
            ->times(7)
            ->andReturn(
                [
                'city' => 'São Joaquim de Bicas',
                'zipCode' => '32000-000',
                'neighborhood' => 'Vila Rica',
                'street' => 'Santa clara',
                'number' => 160,
                'observation' => '',
                ]
            );

        // Action
        $actual = $orderController->resolveOrder($request);

        // Assertions
        $this->assertSame('ecommerce.checkout.orderConfirmation', $actual->name());
        $this->assertEquals($expected, $actual->getData()['preparedOrder']);
    }

    public function testShouldResolveOrderForEmptyCart(): void
    {
        // Set
        $request = m::mock(AddressRequest::class);
        $orderRepository = m::mock(OrderRepository::class);
        $orderController = new OrderController($orderRepository);

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturnNull();

        // Action
        $actual = $orderController->resolveOrder($request);

        // Assertions
        $this->assertSame(302, $actual->status());

    }

    private function getOrderAttibutes(): array
    {
        return [
            'user_id' => 1,
            'city' => "Igarapé",
            'neighborhood' => "Meriti",
            'street' => "Rua Igarapé",
            'number' => "85",
            'status' => "aguardando confirmacao de pagamento",
            'observation' => "",
            'pickUpInStore' => 0,
            'cart_id' => 1,
            'id' => 1,
        ];
    }
}
