<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class OrderRepositoryTest extends TestCase
{
    public function testShouldGetAllOrders(): void
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

    public function testShouldGetOrderByUserId(): void
    {
        // Set
        $order = $this->getOrder();
        $orderRepository = new OrderRepository($order);
        $builder = m::mock(Builder::class);
        $collection = new Collection($order);

        // Expectations
        $order->expects()
            ->where(['user_id' => 1234])
            ->andReturn($builder);

        $builder->expects()
            ->get()
            ->andReturn($collection);

        // Action
        $actual = $orderRepository->getOrderById(1234);

        // Assertions
        $this->assertSame($this->getAttributes(), $actual->toArray());
    }

    public function testShouldGetFirstOrderById(): void
    {
        // Set
        $order = $this->getOrder();
        $orderRepository = new OrderRepository($order);

        // Expectations
        $order->expects()
            ->find(1234)
            ->andReturn($order);

        // Action
        $actual = $orderRepository->first(1234);

        // Assertions
        $this->assertSame($this->getAttributes(), $actual->toArray());
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
