<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function showHome() : View
    {
        return view('ecommerce.home.welcome', ['products' =>  Product::all()]);
    }
}
