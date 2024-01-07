<?php

namespace Tests\Unit\App\Http\Clients;

use App\Http\Clients\MercadoPago;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Container\Container;
use MercadoPago\Preference;
use MercadoPago\SDK;
use Mockery as m;
use Tests\TestCase;

class MercadoPagoTest extends TestCase
{

    public function testShouldMakeAPaymentLink() : void
    {
        // Set
        $config = m::mock(ConfigRepository::class);
        $container = m::mock(Container::class);
        SDK::setAccessToken(config('mercadoPago.access'));
        $preference = m::mock(Preference::class);
        $preference->init_point = 'https://payment-link';
        $items = [
            [
                'id' => 10,
                'name' => 'product',
                'quantity' => 1,
                'price' => 9
            ]
        ];

        $mercadoPago = new MercadoPago($config, $container);

        // Expectations
        $config->expects()
            ->get('mercadoPago.access')
            ->andReturn("TEST-3030807514700823-032620-68626e53e3b7e1846a8ec0fc3d3ea953-274055464");

        $config->expects()
            ->get('mercadoPago.back_urls.success')
            ->andReturn("https://sucess");

        $config->expects()
            ->get('mercadoPago.back_urls.failure')
            ->andReturn("https://failure");

        $config->expects()
            ->get('mercadoPago.back_urls.pending')
            ->andReturn("https://pending");

        $config->expects()
            ->get('mercadoPago.status.approved')
            ->andReturn("aproved");

        $container->expects()
            ->make(Preference::class)
            ->andReturn($preference);

        $preference->expects()
            ->save()
            ->andReturnTrue();

        // Action
        $actual = $mercadoPago->makePaymentLink($items);

        // Assertions
        $this->assertSame('https://payment-link', $actual);
    }
}
