<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressRequest;
use App\Mail\ClientNewOrder;
use App\Mail\NewOrder;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
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

    public function resolveOrder(AddressRequest $request): View
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
                'zipCode' => env('zipCode'),
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
                'zipCode' => $request->zipCode,
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
        $order = json_decode($request->cookie('order'), 1)[0];

        $createdOrder = $this->createOrder($order);
        $payment = app(PaymentController::class);
        $paymentUrl = $payment->makePayments($order['completeCartItems']);

        $this->sendEmails($createdOrder, $paymentUrl );


        return redirect($paymentUrl);
    }

    public function showOrderDetail(string $id): View
    {
        $order = Order::find((int)$id);

        return auth()->user()->rule ?
            view('admin.orders.orderDetail', compact('order')) :
            view('ecommerce.orders.orderDetail', compact('order')) ;
    }


    private function unsetCookies(): void
    {

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

    private function createCart(array $order, $userId): Cart
    {
        return Cart::create([
            'user_id' => $userId,
            'products' => json_encode($order['completeCartItems']),
            'total' => $order['total'],
        ]);
    }

    private function createOrder(array $order): Order
    {
        $userId = auth()->id();
        $cart = $this->createCart($order, $userId);
        $order = Order::create([
            'user_id' => $userId,
            'cart_id' => $cart->id,
            'city' => $order['city'],
            'street' => $order['street'],
            'number' => $order['number'],
            'neighborhood' => $order['neighborhood'],
            'observation' => $order['observation'] ?? 'Não há',
            'status' => 'aguardando confirmacao de pagamento',
            'pickUpInStore' => $order['pickUpInStore'],
        ]);

        $this->unsetCookies();

        return  $order;
    }

    private function sendEmails(Order $createdOrder, string $paymentUrl): void
    {


        Mail::to(env('MAIL_USERNAME'))->send(new NewOrder($createdOrder));
        Mail::to(auth()->user()->email)->send(new ClientNewOrder($createdOrder, $paymentUrl));

    }


}
