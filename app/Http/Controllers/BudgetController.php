<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

use PDF;


use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function showShoppingList(Request $request)
    {
        $cart = json_decode($request->cookie('cart'));

        if (!empty($cart)) {
            return view('ecommerce.checkout.cart', ['cart' => $cart]);

        }

        return view('ecommerce.checkout.emptyCart');

    }

    public function save(Request $request)
    {

        $completeCart = $this->getCartInformation();

        if (!empty($this->validateStock($completeCart))) {
            echo "O pedido não pode ser integrado por falta de estoque";
        }

        Cart::create([
            'user_id' => auth()->id(),
            'products_id' => json_encode(array_keys($completeCart)) ,
            'total' => $this->getTotalPrice($completeCart),
        ]);



        if ($request->method() == 'GET') {


        }
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
            $total += ($item['price'] * $item['quantity']) ;
        }

        return $total;
    }

    private function validateStock(array $items): array
    {

        $result = [];
        foreach ($items as $key => $item) {

            $product = Product::find($key);
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
