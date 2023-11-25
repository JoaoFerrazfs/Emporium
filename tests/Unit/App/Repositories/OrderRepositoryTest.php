<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    public function testShouldReturnCreatedOrders(): void
    {
        // Set
        $order = $this->getOrder();
        $orderRepository = new OrderRepository($order);

        // Expectations
        $order->expects()
            ->all()
            ->andReturn(new Collection([$this->getAttributes()]));

        // Action
        $actual = $orderRepository->getAllOrders();

        // Assertions
        $this->assertSame($this->getAttributes(), $actual->first());
    }

    private function getOrder(): Order
    {
        $order = m::mock(Order::class)->makePartial();
        $order->fill($this->getAttributes());

        return $order;
    }

    private function getAttributes(): array
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
        ];
    }

}
