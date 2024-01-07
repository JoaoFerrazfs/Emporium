<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Clients\MercadoPago as Client;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function __construct(
        private readonly Client $clientMercadoPago
    ) {
    }

    public function makePayments($cart): string
    {
        return $this->clientMercadoPago->makePaymentLink($cart);
    }
}
