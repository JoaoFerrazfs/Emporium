<?php

namespace App\Http\Clients;

use Illuminate\Container\Container;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use Illuminate\Config\Repository as ConfigRepository;

class MercadoPago
{
    public function __construct(
        private readonly ConfigRepository $configRepository,
        private readonly Container $container
    ) {
    }

    public function makePaymentLink(array $cartItems): string
    {
        $this->setAccessToken();

        $mercadoItems = [];

        foreach ($cartItems as $item) {
            $mpItem = new Item();

            $mpItem->id = $item['id'];
            $mpItem->title = $item['name'];
            $mpItem->quantity = $item['quantity'];
            $mpItem->unit_price = $item['price'];

            $mercadoItems[] = $mpItem;
        }

        return $this->configPreference($mercadoItems);
    }

    private function setAccessToken():void
    {
        SDK::setAccessToken($this->configRepository->get('mercadoPago.access'));
    }

    private function configPreference(array $mercadoItems): string
    {
        $preference = $this->container->make(Preference::class);

        $preference->back_urls = [
            'success' => $this->configRepository->get('mercadoPago.back_urls.success'),
            'failure' => $this->configRepository->get('mercadoPago.back_urls.failure'),
            'pending' => $this->configRepository->get('mercadoPago.back_urls.pending')
        ];

        $preference->auto_return = $this->configRepository->get('mercadoPago.status.approved');
        $preference->items = $mercadoItems;

        $preference->save();

        return  $preference->init_point;
    }
}
