<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Clients\MercadoPago as Client;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    private Client $clientMercadoPago;

    public function __construct(Client $clientMercadoPago)
    {
        $this->clientMercadoPago = $clientMercadoPago;
    }

    public function makePayments($cart): string
    {
        return $this->clientMercadoPago->makePaymentLink($cart);
    }
}
