<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function __construct(ProductRepository $Productrepository)
    {
        $this->productRepository = $Productrepository;
    }

    public function getProducts(Request $request)
    {
        $term = $request->get('search_term', false);
        $products =  $term ?
            $this->productRepository->findAvailableProductByName($term):
            $this->productRepository->findAllAvailableProducts();

        return view('ecommerce.products.productsList', ['products' => $products]);

    }
}
