<?php

namespace App\Http\Clients;

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class MercadoPago
{
    public function __construct()
    {
        SDK::setAccessToken(config('mercadoPago.access'));
    }

    public function makePaymentLink(array $cartItems): string
    {
        $mercadoItems = [];

        foreach ($cartItems as $item){

            $mpItem = new Item();

            $mpItem->id = $item['id'];
            $mpItem->title = $item['name'];
            $mpItem->quantity = $item['quantity'];
            $mpItem->unit_price = $item['price'];

            $mercadoItems[] = $mpItem;
        }

        return $this->configPreference($mercadoItems);
    }

    private function configPreference(array $mercadoItems): string
    {
        $preference = new Preference();

        $preference->back_urls = array(
            'success' => config('mercadoPago.back_urls.success'),
            'failure' => config('mercadoPago.back_urls.failure'),
            'pending' => config('mercadoPago.back_urls.pending')
        );

        $preference->auto_return = config('mercadoPago.status.approved');
        $preference->items = $mercadoItems;

        $preference->save();

        return  $preference->init_point;
    }
}
