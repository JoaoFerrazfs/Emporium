<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Budget;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PdfController;
use PDF;
use App\Http\Controllers\PaymentController;
use App\Models\Client;




use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * @var ClientController
     */
    private $clientController;

     /**
      * @var ProductController
      */
    private $productController;

     /**
      * @var Budget
      */
    private $budget;

         /**
          * @var PaymentController
          */
    private $paymentController;




    public function __construct(
        ClientController $clientController,
        ProductController $productController,
        Budget $budget,
        PaymentController $paymentController
    ) {
        $this->clientController = $clientController;
        $this->productController = $productController;
        $this->budget = $budget;
        $this->paymentController = $paymentController;

    }

    public function showShoppingList(Request $request)
    {
        $cart = json_decode($request->cookie('cart'));

        if(!empty($cart)) {
            return view('ecommerce.checkout.cart', ['cart' => $cart]);

        }

        return view('ecommerce.checkout.emptyCart');

    }

    public function deleteItemShoppingList(Request $request)
    {

        $key = $request->key;
        $cart = $request->session()->get('cart');
        unset($cart[$key]);
        session()->forget('cart');
        session()->put('cart', $cart);
        if(session()->put('cart', $cart) == null) {
            return redirect('/produtos');
        }

        return redirect()->back();
    }

    public function deleteCart(Request $request)
    {
        session()->forget('cart');
        return redirect('/produtos');
    }

    public function updateQuantity(Request $request)
    {
        $key = $request->key;
        $cart = $request->session()->get('cart');
        $cart[$key]["quantity"] =  $request->amount;
        session()->forget('cart');
        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function newBudget(Request $request)
    {
        $cart = $request->session()->get('cart');
        $amount = 0;

        foreach ($cart as $value) {
            $quantity = $value["quantity"];
            $amount =  $amount + ($quantity * $value["price"]);
        }

        $request->session()->put('cartAmout', $amount);
        return view(
            'ecommerce.viewBudget', [
            'amount' => $amount,
            'cart' => $cart,

            ]
        );
    }

    public function saveBudget(Request $request)
    {

        $budgetNumber = Budget::all()->count() + 1;
        $cart = $request->session()->get('cart');

        $delivery = [
            "name" => $request->name,
            "phoneNumber" => $request->phoneNumber,
            "cpf" => $request->cpf,
            "cep" => $request->cep,
            "street" => $request->street,
            "state" => $request->state,
            "city" => $request->city,
            "number" => $request->number
        ];



        $this->clientController->store($delivery);

        $this->budget->number = $budgetNumber;
        $this->budget->statusPayment = 'Em espera';
        $this->budget->delivery = $delivery;
        $this->budget->products = $cart;
        $this->budget->note =  $request->note;
        $this->budget->portage =  $request->session()->get('portage');
        $this->budget->amount =  $request->session()->get('cartAmout') + $request->session()->get('portage');
        foreach ($cart as $key => $value) {
            $id = $value['id'];
            $inventory = $value['quantity'];

            $this->productController->changedStore($id, $inventory);
        }
        $request->session()->put('budget',  $this->budget);
        $this->budget->save();
        $paymentLink =  $this->paymentController->payments($cart);
        return redirect($paymentLink);
    }
}
