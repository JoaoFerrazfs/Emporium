<?php

namespace App\Http\Controllers;

use App\Http\Clients\MercadoPago as Client;

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
