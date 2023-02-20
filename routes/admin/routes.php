<?php

use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\OrderManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServicesController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::get('/cadastroProduto', function () {
    return view('admin.products.productRegistration');
});

Route::post('/validaCadastro',[ProductController::class,'store'])->middleware('auth');
Route::get('/meusProdutos',[ProductController::class,'myProducts'])->middleware('auth');
Route::get('/meusProdutos/editarProdutos/{id}',[ProductController::class,'editProducts'])->middleware('auth');
Route::post('/meusProdutos/salvaEdicao',[ProductController::class,'update'])->middleware('auth');
Route::post('/meusProdutos/order',[ProductController::class,'changeOrder'])->middleware('auth');
Route::post('/meusProdutos/availability',[ProductController::class,'changeAvailability'])->middleware('auth');
Route::delete('/meusProdutos/delete/{id}',[ProductController::class,'destroy'])->middleware('auth');
Route::post('/pedido/confirmado',[BudgetController::class,'saveBudget']);
Route::get('/pedidos/{id}',[OrderManagerController::class,'manager'])->middleware('auth');
Route::post('/pedidos/visualizar',[OrderManagerController::class,'showOrder']);
Route::post('/pedidos/atualizar',[OrderManagerController::class,'updateStatusOrder']);
Route::post('/novoBanner',[BannerController::class,'create']);
Route::get('/prestador/registrar', function () {return view('admin.services.servicesRegistration');
});
Route::post('/validaCadastroPrestador',[ServicesController::class,'create']);
Route::get('/prestador/visualizar',[ServicesController::class,'view'])->middleware('auth');
Route::get('/prestadores',[ServicesController::class,'viewAllServices']);






