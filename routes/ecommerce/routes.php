<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductSearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('/',[HomeController::class,'showHome']) ->name('home');
Route::get('/produtos',[ProductController::class,'index'])->name('products.list');
Route::get('/produto/{id}',[ProductController::class,'viewProduct'])->name('product.page');
Route::get('/carrinho/visualizar',[OrderController::class,'showShoppingList'])->name('cart');

Route::middleware(['auth', 'hasAvailableCart'])->group(function () {
    Route::get('/frete', function () {return view('ecommerce.checkout.freight') ;})->name('freight');
    Route::post('/cadastrarPedido', [OrderController::class,'resolveOrder'])->name('order.with.freight');
    Route::get('/cadastrarPedido', [OrderController::class,'resolveOrder'])->name('order.with.freight');
    Route::get('/processarPedido', [OrderController::class,'save'])->name('process.order');
    Route::get('/processarPedido', [OrderController::class,'save'])->name('process.order');

});

Route::get('/pedidos',[OrderController::class,'getUserOrders'])->name('client.orders');
Route::get('/emContrucao', fn() =>  view('commons.buildingFunction'))->name('building.page');
Route::get('/contato', fn() =>  view('ecommerce.about.contact'))->name('about');
Route::get('/produtos/pesquisa',[ProductSearchController::class,'getProducts'])->name('product.search');





