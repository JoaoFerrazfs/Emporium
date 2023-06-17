<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    public function testShouldReturnAnViewWithOrders(): void
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
    private function getOrderAttibutes(): array
    {
        return [
            'user_id'=> 1,
            'city'=> "Igarapé",
            'neighborhood'=> "Meriti",
            'street'=> "Rua Igarapé",
            'number'=> "85",
            'status'=> "aguardando confirmacao de pagamento",
            'observation'=> "",
            'pickUpInStore'=> 0,
            'cart_id'=> 1,
            'id' => 1,
        ];
    }
}
