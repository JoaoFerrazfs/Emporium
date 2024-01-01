<?php

namespace Tests\Unit\App\Http\Checkout;

use App\Http\Controllers\Checkout\DataTransferObject\OrderFactory;
use App\Http\Controllers\Checkout\OrderController;
use App\Http\Controllers\Checkout\PaymentController;
use App\Http\Requests\Address\AddressRequest;
use App\Mail\NewOrder;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\CartRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use DateTime;
use Exception;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Mail;
use Mockery as m;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testShouldSaveOrders(): void
    {
        // Set
        $orderRepository = m::mock(OrderRepository::class);
        $productRepository = m::mock(ProductRepository::class);
        $configRepository = m::mock(ConfigRepository::class);
        $cartRepository = m::mock(CartRepository::class);
        $paymentController = m::mock(PaymentController::class);
        $pendingMail = m::mock(PendingMail::class);
        $orderFactory = m::mock(OrderFactory::class)->makePartial();
        $user = $this->makeUser();
        $cart = $this->makeCart();
        $orderInfo = $this->getOrderInformation();
        $request = m::mock(Request::class);

        $orderController = new OrderController(
            $orderRepository,
            $productRepository,
            $configRepository,
            $cartRepository,
            $paymentController,
            $orderFactory
        );

        $orderData = [
            'name' => 'userName',
            'city' => 'BH',
            'street' => 'amazonas',
            'number' => 1250,
            'neighborhood' => 'centro',
            'observation' => 'some observation',
            'pickUpInStore' => 1,
            'created_at' => '12/12/2023',
        ];
        $order = m::mock(Order::class)->makePartial()->fill($orderData);
        $order->id = 1;

        // Expectations
        $request->expects()
            ->cookie('order')
            ->andReturn(json_encode([$orderInfo['orderCookie']], true));

        $request->expects()
            ->user()
            ->andReturn($user);

        $pendingMail->expects()
            ->send('')
            ->withAnyArgs()
            ->andReturn();

        $pendingMail->expects()
            ->send('')
            ->withAnyArgs()
            ->andReturn();

        Mail::shouldReceive('to')->andReturn($pendingMail);
        Mail::shouldReceive('to')->andReturn($pendingMail);

        $cartRepository->expects()
            ->create($orderInfo['cartData'])
            ->andReturn($cart);

        $orderRepository->expects()
            ->create($orderInfo['orderInfo'])
            ->andReturn($order);

        $order->expects()
            ->getAttribute('user')
            ->andReturn($user);

        $order->expects()
            ->getAttribute('cart')
            ->andReturn($cart);

        $paymentController->expects()
            ->makePayments(m::type('array'))
            ->andReturn('https://paymentlink');

        // Actions
        $actual = $orderController->save($request);

        // Assertions
        $this->assertSame(302, $actual->getStatusCode(),);
    }

    public function testShouldReturnAViewWithOrders(): void
    {
        // Set
        $orderRepository = m::mock(OrderRepository::class);
        $productRepository = m::mock(ProductRepository::class);
        $configRepository = m::mock(ConfigRepository::class);
        $cartRepository = m::mock(CartRepository::class);
        $paymentController = m::mock(PaymentController::class);
        $orderFactory = m::mock(OrderFactory::class);

        $orderController = new OrderController(
            $orderRepository,
            $productRepository,
            $configRepository,
            $cartRepository,
            $paymentController,
            $orderFactory
        );

        $order = new Order();
        $order->fill($this->getOrderAttributes());
        $order->id = 1;

        // Expectations
        $orderRepository->expects()
            ->getAllOrders()
            ->andReturn(new Collection([$order]));

        // Actions
        $actual = $orderController->index();

        // Assertions
        $this->assertSame('admin.orders.home', $actual->name());
        $order = $actual->getData()['orders'][0];
        $this->assertSame($this->getOrderAttributes(), $order->getAttributes());
    }

    public function testShouldReturnAViewUserOrders(): void
    {
        // Set
        $request = m::mock(Request::class);
        $user = m::mock(User::class);
        $orderRepository = m::mock(OrderRepository::class);
        $productRepository = m::mock(ProductRepository::class);
        $configRepository = m::mock(ConfigRepository::class);
        $cartRepository = m::mock(CartRepository::class);
        $paymentController = m::mock(PaymentController::class);
        $orderFactory = m::mock(OrderFactory::class);

        $orderController = new OrderController(
            $orderRepository,
            $productRepository,
            $configRepository,
            $cartRepository,
            $paymentController,
            $orderFactory
        );

        $order = new Order();
        $order->fill($this->getOrderAttributes());
        $order->id = 1;

        // Expectations
        $request->expects()
            ->user()
            ->andReturn($user);

        $user->expects()
            ->getAttribute('id')
            ->andReturn(1);

        $orderRepository->expects()
            ->getOrderById('1')
            ->andReturn(new Collection([$order]));

        // Actions
        $actual = $orderController->getUserOrders($request);

        // Assertions
        $this->assertSame('ecommerce.user.orders.orders', $actual->name());
        $order = $actual->getData()['orders'][0];
        $this->assertSame($this->getOrderAttributes(), $order->getAttributes());
    }

    public function testShouldReturnAShoppingList(): void
    {
        // Set
        $request = m::mock(Request::class);
        $orderRepository = m::mock(OrderRepository::class);
        $productRepository = m::mock(ProductRepository::class);
        $configRepository = m::mock(ConfigRepository::class);
        $cartRepository = m::mock(CartRepository::class);
        $paymentController = m::mock(PaymentController::class);
        $orderFactory = m::mock(OrderFactory::class);

        $orderController = new OrderController(
            $orderRepository,
            $productRepository,
            $configRepository,
            $cartRepository,
            $paymentController,
            $orderFactory
        );

        $cart = [
            [
                "id" => 10,
                "name" => "Pizza",
                "description" => "Pizza promoção",
                "ingredients" => "tudo e mais um pouco",
                "price" => 9.99,
                "image" => "pizza1.jpg",
                "status" => "disponivel",
                "stock" => 99,
                "validate" => "2023-06-11",
                "created_at" => "2023-06-10T20:26:06.000000Z",
                "updated_at" => "2023-06-10T20:26:06.000000Z"
            ]
        ];

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturn(json_encode($cart));

        // Actions
        $actual = $orderController->showShoppingList($request);

        // Assertions
        $this->assertSame('ecommerce.checkout.cart', $actual->name());
        $this->assertEquals($cart, $actual->getData()['cart']);
    }

    public function testShouldReturnEmptyShoppingListPage(): void
    {
        // Set
        $request = m::mock(Request::class);
        $orderRepository = m::mock(OrderRepository::class);
        $productRepository = m::mock(ProductRepository::class);
        $configRepository = m::mock(ConfigRepository::class);
        $cartRepository = m::mock(CartRepository::class);
        $paymentController = m::mock(PaymentController::class);
        $orderFactory = m::mock(OrderFactory::class);

        $orderController = new OrderController(
            $orderRepository,
            $productRepository,
            $configRepository,
            $cartRepository,
            $paymentController,
            $orderFactory
        );

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturnNull();

        // Actions
        $actual = $orderController->showShoppingList($request);

        // Assertions
        $this->assertSame('ecommerce.checkout.emptyCart', $actual->name());
    }

    public function testShouldResolveOrderForGetRequisition(): void
    {
        // Set
        $request = m::mock(AddressRequest::class);
        $product = m::mock(Product::class);
        $orderRepository = m::mock(OrderRepository::class);
        $productRepository = m::mock(ProductRepository::class);
        $configRepository = m::mock(ConfigRepository::class);
        $cartRepository = m::mock(CartRepository::class);
        $paymentController = m::mock(PaymentController::class);
        $orderFactory = m::mock(OrderFactory::class);

        $orderController = new OrderController(
            $orderRepository,
            $productRepository,
            $configRepository,
            $cartRepository,
            $paymentController,
            $orderFactory
        );

        $cart = [
            [
                "id" => 10,
                "name" => "Pizza",
                "description" => "Pizza promoção",
                "ingredients" => "tudo e mais um pouco",
                "price" => 9.99,
                "image" => "pizza1.jpg",
                "status" => "disponivel",
                "stock" => 99,
                "validate" => "2023-06-11",
                "created_at" => "2023-06-10T20:26:06.000000Z",
                "updated_at" => "2023-06-10T20:26:06.000000Z"
            ]
        ];
        $expected = [
            'user_id' => null,
            'zipCode' => '32920-000',
            'neighborhood' => 'Pedra Branca',
            'city' => 'Sao Joaquim de Bicas',
            'street' => 'Poços de Caldas',
            'number' => '26',
            'status' => 'Aguardando confirmacao',
            'completeCartItems' => [[
                'id' => 10,
                'quantity' => 1,
                'name' => 'Pizza',
                'price' => 9.99,
                'stock' => 99,
            ]],
            'total' => 9.99,
            'pickUpInStore' => true,
        ];

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturn(json_encode($cart));

        $request->expects()
            ->method()
            ->andReturn('GET');

        $productRepository->expects()
            ->first(0)
            ->andReturn($product);

        $product->expects()
            ->hasEnoughStock(1)
            ->andReturnTrue();

        $configRepository->expects()
            ->get('companyData.address.zipCode')
            ->andReturn('32920-000');

        $configRepository->expects()
            ->get('companyData.address.neighborhood')
            ->andReturn('Pedra Branca');

        $configRepository->expects()
            ->get('companyData.address.city')
            ->andReturn('Sao Joaquim de Bicas');

        $configRepository->expects()
            ->get('companyData.address.street')
            ->andReturn('Poços de Caldas');

        $configRepository->expects()
            ->get('companyData.address.number')
            ->andReturn('26');

        // Action
        $actual = $orderController->resolveOrder($request);

        // Assertions
        $this->assertSame('ecommerce.checkout.orderConfirmation', $actual->name());
        $this->assertEquals($expected, $actual->getData()['preparedOrder']);
    }

    public function testShouldResolveOrderForPostRequisition(): void
    {
        // Set
        $product = m::mock(Product::class);
        $request = m::mock(AddressRequest::class);
        $orderRepository = m::mock(OrderRepository::class);
        $productRepository = m::mock(ProductRepository::class);
        $configRepository = m::mock(ConfigRepository::class);
        $cartRepository = m::mock(CartRepository::class);
        $paymentController = m::mock(PaymentController::class);
        $orderFactory = m::mock(OrderFactory::class);

        $orderController = new OrderController(
            $orderRepository,
            $productRepository,
            $configRepository,
            $cartRepository,
            $paymentController,
            $orderFactory
        );

        $cart = [
            [
                "id" => 10,
                "name" => "Pizza",
                "description" => "Pizza promoção",
                "ingredients" => "tudo e mais um pouco",
                "price" => 9.99,
                "image" => "pizza1.jpg",
                "status" => "disponivel",
                "stock" => 99,
                "validate" => "2023-06-11",
                "created_at" => "2023-06-10T20:26:06.000000Z",
                "updated_at" => "2023-06-10T20:26:06.000000Z"
            ]
        ];
        $expected = [
            'user_id' => null,
            'zipCode' => '32000-000',
            'neighborhood' => 'Vila Rica',
            'city' => 'São Joaquim de Bicas',
            'street' => 'Santa clara',
            'observation' => '',
            'number' => 160,
            'status' => 'Aguardando confirmacao',
            'completeCartItems' => [[
                'id' => 10,
                'quantity' => 1,
                'name' => 'Pizza',
                'price' => 9.99,
                'stock' => 99,
            ]],
            'total' => '16.99',
            'pickUpInStore' => false,
        ];

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturn(json_encode($cart));

        $request->expects()
            ->method()
            ->twice()
            ->andReturn('POST');

        $request->expects()
            ->all()
            ->times(7)
            ->andReturn(
                [
                'city' => 'São Joaquim de Bicas',
                'zipCode' => '32000-000',
                'neighborhood' => 'Vila Rica',
                'street' => 'Santa clara',
                'number' => 160,
                'observation' => '',
                ]
            );

        $productRepository->expects()
            ->first(0)
            ->andReturn($product);

        $product->expects()
            ->hasEnoughStock(1)
            ->andReturnTrue();

        // Action
        $actual = $orderController->resolveOrder($request);

        // Assertions
        $this->assertSame('ecommerce.checkout.orderConfirmation', $actual->name());
        $this->assertEquals($expected, $actual->getData()['preparedOrder']);
    }

    public function testShouldResolveOrderForEmptyCart(): void
    {
        // Set
        $request = m::mock(AddressRequest::class);
        $orderRepository = m::mock(OrderRepository::class);
        $productRepository = m::mock(ProductRepository::class);
        $configRepository = m::mock(ConfigRepository::class);
        $cartRepository = m::mock(CartRepository::class);
        $paymentController = m::mock(PaymentController::class);
        $orderFactory = m::mock(OrderFactory::class);

        $orderController = new OrderController(
            $orderRepository,
            $productRepository,
            $configRepository,
            $cartRepository,
            $paymentController,
            $orderFactory
        );

        // Expectations
        $request->expects()
            ->cookie('cart')
            ->andReturnNull();

        // Action
        $actual = $orderController->resolveOrder($request);

        // Assertions
        $this->assertSame(302, $actual->status());
    }

    private function getOrderAttributes(): array
    {
        return [
            'user_id' => 1,
            'city' => "Igarapé",
            'neighborhood' => "Meriti",
            'street' => "Rua Igarapé",
            'number' => "85",
            'status' => "aguardando confirmacao de pagamento",
            'observation' => "",
            'pickUpInStore' => 0,
            'cart_id' => 1,
            'id' => 1,
        ];
    }

    private function makeUser(): User
    {
        $user = new User([
            'name' => 'userName',
            'email' => 'useremail@gmail.com',
            'phone' => '99 99999999'
        ]);
        $user->id = 1;

        return $user;
    }

    private function makeCart(): Cart
    {
        $cart = new Cart([
            'products' => '[{"id":"88", "name": "Product A", "quantity": 2, "price": 19.99}]',
            'total' => 100,
            'createdAt' => new DateTime('12/12/2023'),
        ]);
        $cart->id = 1;
        return $cart;
    }

    private function getOrderInformation(): array
    {
        $orderCookie = [
            'user_id' => 1,
            'cart_id' => 1,
            'zipCode' => '32920-000',
            'neighborhood' => 'Pedra Branca',
            'city' => 'Sao Joaquim de Bicas',
            'street' => 'Poços de Caldas',
            'number' => '26',
            'status' => 'Aguardando confirmacao',
            'completeCartItems' => [
                [
                    'id' => 59,
                    'quantity' => 1,
                    'name' => 'Pizzasas',
                    'price' => 3.23,
                    'stock' => 1,
                ],
            ],
            'total' => 3.23,
            'pickUpInStore' => true,
        ];
        $cartData = [
            'user_id' => null,
            'products' => '[{"id":59,"quantity":1,"name":"Pizzasas","price":3.23,"stock":1}]',
            'total' => 3.23
        ];
        $orderInfo = [
            'user_id' => null,
            'cart_id' => 1,
            'city' => 'Sao Joaquim de Bicas',
            'street' => 'Poços de Caldas',
            'number' => '26',
            'neighborhood' => 'Pedra Branca',
            'observation' => 'Não há',
            'status' => 'aguardando confirmacao de pagamento',
            'pickUpInStore' => true
        ];

        return compact('orderCookie', 'cartData', 'orderInfo');
    }
}
