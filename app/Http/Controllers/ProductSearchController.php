<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductSearchController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function getProducts(Request $request): View
    {
        $term = $request->get('search_term');
        $products =  $term ?
            $this->productRepository->findAvailableProductByName($term):
            $this->productRepository->findAllAvailableProducts();

        return view('ecommerce.products.productsList', ['products' => $products]);
    }
}
