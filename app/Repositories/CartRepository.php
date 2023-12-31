<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    public function __construct(
        private readonly Cart $cart
    ) {
    }

    public function create(array $cartData): Cart
    {
        return  $this->cart->create($cartData);
    }
}
