<?php

namespace App\Http\Controllers\Checkout\DataTransferObject;

use DateTime;

readonly class OrderDTO
{
    private function __construct(
        public int      $id,
        public array    $address,
        public string   $observation,
        public bool     $pickUpInStore,
        public DateTime $createdAt,
        public array    $user,
        public array    $cart,
    ) {
    }

    public static function buildFromArray(array $order): self
    {
        return new self(
            $order['id'],
            $order['address'],
            $order['observation'],
            $order['pickUpInStore'],
            $order['createdAt'],
            $order['user'],
            $order['cart']
        );
    }
}
