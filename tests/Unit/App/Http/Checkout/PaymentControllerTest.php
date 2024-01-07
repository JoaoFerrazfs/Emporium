<?php

namespace Tests\Unit\App\Http\Checkout;

use App\Http\Clients\MercadoPago as Client;
use App\Http\Controllers\Checkout\PaymentController;
use Mockery as m;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{

    public function testShouldMakePaymentLink(): void
    {
        // Set

        $client = m::mock(Client::class);
        $paymentController = new PaymentController($client);

        // Expectations



        // Action
        $actual = $paymentController->makePayments();
    }

}
