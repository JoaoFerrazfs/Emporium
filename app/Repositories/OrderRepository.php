<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getAllOrders(): Collection
    {
        return $this->order->all();
    }

    public function getOrderById(int $userId): Collection
    {
        return $this->order->where(['user_id' => $userId])->get();
    }

    public function first(int $orderUd): ?Order
    {
        return $this->order->find($orderUd);
    }
}
