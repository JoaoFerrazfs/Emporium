<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;
use PDF;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private const DEFAULT_FREIGHT_VALUE = 7;

    public function showShoppingList(Request $request): View
    {
        $cart = json_decode($request->cookie('cart'));

        if (!empty($cart)) {
            return view('ecommerce.checkout.cart', ['cart' => $cart]);

        }

        return view('ecommerce.checkout.emptyCart');

    }

    public function resolveOrder(Request $request): View
    {

        $completeCartItems = $this->getCartInformation();
        $preparedOrder = [];
        $totalPrice = $this->getTotalPrice($completeCartItems);

        if (!empty($this->validateStock($completeCartItems))) {
            echo "O pedido não pode ser integrado por falta de estoque";
        }

        if ($request->method() == 'GET') {
            $preparedOrder = [
                'user_id' => auth()->id(),
                'zipCode' =>  env('zipCode'),
                'neighborhood' => env('NEIGHBORHOOD'),
                'city' => env('CITY'),
                'street' => env('STREET'),
                'number' => env('NUMBER'),
                'status' => 'Aguardando confirmacao',
                'completeCartItems' => $completeCartItems,
                'total' => $totalPrice,
                'pickUpInStore' => true,
            ];
        }

        if ($request->method() == 'POST') {
            $preparedOrder = [
                'user_id' => auth()->id(),
                'city' => $request->city,
                'zipCode' =>  $request->zipCode,
                'neighborhood' => $request->neighborhood,
                'street' => $request->street,
                'number' => $request->number,
                'observation' => $request->observation ?? '',
                'status' => 'Aguardando confirmacao',
                'completeCartItems' => $completeCartItems,
                'total' => $totalPrice + self::DEFAULT_FREIGHT_VALUE,
                'pickUpInStore' => false,

            ];
        }

        return view('ecommerce.checkout.orderConfirmation', compact('preparedOrder'));
    }

    public function save(Request $request): RedirectResponse
    {
       $order = json_decode($request->cookie('order'),1)[0];
       $userId = auth()->id();

       $cart =  Cart::create([
            'user_id' => $userId,
            'products_id' => json_encode(array_keys(array_column($order['completeCartItems'],'id'))),
            'total' =>$order['total'],
        ]);


       $order = Order::create([
           'user_id' => $userId ,
           'cart_id' => $cart->id,
           'city' => $order['city'] ,
           'street' => $order['street'],
           'number' => $order['number'],
           'observation' => $order['observation'] ?? 'Não há',
           'status' => 'aguardando confirmacao de pagamento',
       ]);


       $this->unsetCookies();

       return redirect(route('building.page'));
    }

    private function unsetCookies():void {

        setcookie('order', null, -1);
        setcookie('totalCart', null, -1);
        setcookie('cart', null, -1);
    }

    private function getCartInformation(): array
    {
        $items = json_decode(Cookie::get('cart'), true);

        $treatedItems = [];
        foreach ($items as $item) {

            if (array_key_exists($item['id'], $treatedItems)) {
                $treatedItems[$item['id']]['quantity']++;
                continue;
            }

            $treatedItems[$item['id']]['id'] = $item['id'];
            $treatedItems[$item['id']]['quantity'] = 1;
            $treatedItems[$item['id']]['name'] = $item['name'];
            $treatedItems[$item['id']]['price'] = $item['price'];
            $treatedItems[$item['id']]['stock'] = $item['stock'];


        }

        return $treatedItems;
    }

    private function getTotalPrice($items): float
    {
        $total = 0;
        foreach ($items as $item) {
            $total += ($item['price'] * $item['quantity']);
        }

        return $total;
    }

    private function validateStock(array $items): array
    {

        $result = [];

        foreach ($items as $key => $item) {

            if (!$product = Product::find($key)) {

                continue;
            }
            if (!$product->hasEnoughStock($item['quantity'])) {
                $result[] = [
                    'id' => $product->id,
                    'avaiableStock' => $product->stock,
                    'necessaryAmount' => $item['quantity'],
                ];
            };

        }

        return $result;

    }

}
