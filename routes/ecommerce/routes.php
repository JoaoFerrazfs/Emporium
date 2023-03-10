<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeliveryRouteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;



Route::get('/',[HomeController::class,'showHome']) ->name('home');
Route::get('/produtos',[ProductController::class,'index'])->name('products.list');

Route::get('/produto/{id}',[ProductController::class,'viewProduct'])->name('product.page');

Route::get('/carrinho/visualizar',[OrderController::class,'showShoppingList'])->name('cart');

Route::middleware(['auth'])->group(function () {
    Route::get('/frete', function () {return view('ecommerce.checkout.freight') ;})->name('freight');
    Route::post('/cadastrarPedido', [OrderController::class,'resolveOrder'])->name('order.with.freight');
    Route::get('/cadastrarPedido', [OrderController::class,'resolveOrder'])->name('order.with.freight');
    Route::get('/processarPedido', [OrderController::class,'save'])->name('process.order');

});

Route::get('/emContrucao', fn() =>  view('commons.buildingFunction'))->name('building.page');

Route::get('/pedido',[OrderController::class,'newBudget']);
Route::post('/pesquisaCPF',[ClientController::class,'findClient']);
Route::get('/formBanner', function () {return view('ecommerce.formBanner') ;});
Route::get('/confirmarPagamento', function () {return view('ecommerce.paymentProcess');});
Route::get('/pagamento',[PaymentController::class,'payments']);
Route::get('/geraPdf',[PdfController::class,'createPdf']);
Route::post('/frete',[DeliveryRouteController::class,'portage']);
Route::get('/pesquisaPedido',[OrderManagerController::class,'searchOrder']);




