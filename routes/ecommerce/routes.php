<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\OrderManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeliveryRouteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;



Route::get('/',[HomeController::class,'showHome']) ->name('home');
Route::get('/produtos',[ProductController::class,'index'])->name('products.list');

Route::get('/produto/{id}',[ProductController::class,'viewProduct'])->name('product.page');

Route::get('/carrinho/visualizar',[BudgetController::class,'showShoppingList'])->name('cart');

Route::delete('/carrinho/item/excluir/{id}',[BudgetController::class,'deleteItemShoppingList']);
Route::get('/pedido',[BudgetController::class,'newBudget']);
Route::post('/carrinho/excluir/carrinho',[BudgetController::class,'deleteCart']);
Route::post('/carrinho/modifica/quantidade',[BudgetController::class,'updateQuantity']);
Route::post('/pesquisaCPF',[ClientController::class,'findClient']);
Route::get('/formBanner', function () {return view('ecommerce.formBanner') ;});
Route::get('/confirmarPagamento', function () {return view('ecommerce.paymentProcess');});
Route::get('/pagamento',[PaymentController::class,'payments']);
Route::get('/geraPdf',[PdfController::class,'createPdf']);
Route::post('/frete',[DeliveryRouteController::class,'portage']);
Route::get('/pesquisaPedido',[OrderManagerController::class,'searchOrder']);




