<?php

namespace App\Http\Controllers\Checkout\DataTransferObject;

use App\Models\Order;
use DateTime;
use Exception;

class OrderFactory
{
    /**
     * @throws Exception
     */
    public function make(Order $orderData): OrderDTO
    {
        return OrderDTO::buildFromArray([
            'id' => $orderData->getAttribute('id'),
            'address' => $this->getAddressData($orderData),
            'observation' => $orderData->getAttribute('observation'),
            'pickUpInStore' => $orderData->getAttribute('pickUpInStore'),
            'createdAt' => new DateTime($orderData->getAttribute('created_at')),
            'user' => $this->getUserData($orderData),
            'cart' => $this->getCartData($orderData)
        ]);
    }


    private function getUserData(Order $order): array
    {
        $user = $order->getAttribute('user');

        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ];
    }

    /**
     * @throws Exception
     */
    private function getCartData(Order $order): array
    {
        $cart = $order->getAttribute('cart');

        return [
            'products' => json_decode($cart->products, true),
            'total' => $cart->total,
            'createdAt' => new DateTime($cart->getAttribute('created_at')),
        ];
    }

    private function getAddressData(Order $order): array
    {
        return [
            'city' => $order->getAttribute('city'),
            'street' => $order->getAttribute('street'),
            'number' => $order->getAttribute('number'),
            'neighborhood' => $order->getAttribute('neighborhood'),
        ];
    }
}
