<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressRequest;
use App\Mail\ClientNewOrder;
use App\Mail\NewOrder;
use App\Models\Order;
use App\Models\Cart;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private const DEFAULT_FREIGHT_VALUE = 7;

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly ProductRepository $productRepository,
        private readonly ConfigRepository $configRepository
    ) {
    }

    public function index(): View
    {
        $orders = $this->orderRepository->getAllOrders();

        return view('admin.orders.home', compact('orders'));
    }

    public function getUserOrders(Request $request): View
    {
        $userId = $request->user()->id;
        $orders = $this->orderRepository->getOrderById($userId);

        return view('ecommerce.user.orders.orders', compact('orders'));
    }

    public function showShoppingList(Request $request): View
    {
        $cart = json_decode($request->cookie('cart'), 1);

        if (!empty($cart)) {
            return view('ecommerce.checkout.cart', ['cart' => $cart]);
        }

        return view('ecommerce.checkout.emptyCart');
    }

    public function resolveOrder(AddressRequest $request): View | RedirectResponse
    {
        if (!$completeCartItems = $this->getCartInformation($request)) {
            return redirect()->back();
        }
        $totalPrice = $this->getTotalPrice($completeCartItems);

        if (!empty($this->validateStock($completeCartItems))) {
            return redirect()->back(400);
        }

        $preparedOrder = [];
        if ($request->method() == 'GET') {
            $preparedOrder = [
                'user_id' => auth()->id(),
                'zipCode' => $this->configRepository->get('companyData.address.zipCode'),
                'neighborhood' => $this->configRepository->get('companyData.address.neighborhood'),
                'city' => $this->configRepository->get('companyData.address.city'),
                'street' => $this->configRepository->get('companyData.address.street'),
                'number' => $this->configRepository->get('companyData.address.number'),
                'status' => 'Aguardando confirmacao',
                'completeCartItems' => $completeCartItems,
                'total' => $totalPrice,
                'pickUpInStore' => true,
            ];

            return view('ecommerce.checkout.orderConfirmation', compact('preparedOrder'));
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
                'total' => number_format($totalPrice + self::DEFAULT_FREIGHT_VALUE, 2, '.'),
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
        $this->sendEmails($createdOrder, $paymentUrl);

        return redirect($paymentUrl);
    }

    public function showOrderDetail(string $id): View
    {
        $order = $this->orderRepository->first((int)$id);

        return auth()->user()->rule ?
            view('admin.orders.orderDetail', compact('order')) :
            view('ecommerce.orders.orderDetail', compact('order'));
    }

    private function unsetCookies(): void
    {
        setcookie('order', null, -1);
        setcookie('totalCart', null, -1);
        setcookie('cart', null, -1);
    }

    private function getCartInformation(AddressRequest $request): ?array
    {
        if (!$items = json_decode($request->cookie('cart'), true)) {
            return null;
        }

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

        return array_values($treatedItems);
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
            if (!$product = $this->productRepository->first($key)) {
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
        return Cart::create(
            [
            'user_id' => $userId,
            'products' => json_encode($order['completeCartItems']),
            'total' => $order['total'],
            ]
        );
    }

    private function createOrder(array $order): Order
    {
        $userId = auth()->id();
        $cart = $this->createCart($order, $userId);
        $order = Order::create(
            [
            'user_id' => $userId,
            'cart_id' => $cart->id,
            'city' => $order['city'],
            'street' => $order['street'],
            'number' => $order['number'],
            'neighborhood' => $order['neighborhood'],
            'observation' => $order['observation'] ?? 'Não há',
            'status' => 'aguardando confirmacao de pagamento',
            'pickUpInStore' => $order['pickUpInStore'],
            ]
        );

        $this->unsetCookies();

        return $order;
    }

    private function sendEmails(Order $createdOrder, string $paymentUrl): void
    {
        Mail::to(env('MAIL_USERNAME'))->send(new NewOrder($createdOrder));
        Mail::to(auth()->user()->email)->send(new ClientNewOrder($createdOrder, $paymentUrl));
    }
}
