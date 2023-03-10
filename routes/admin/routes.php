<?php

use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServicesController;

Route::middleware(['auth','adminUser'])->prefix('admin')->group(function () {

    Route::get('/', function () {
        return redirect('/admin/produtos');
    })->name('admin');

    Route::get('/pedidos', function () {
        return view('/admin/pedidos/home');
    })->name('admin.orders');

    Route::get('/produtos', fn() => view('/admin/products/home'))->name('admin.products');
    Route::get('/produtos/lista',[ProductController::class,'myProducts'])->name('admin.products.list');
    Route::post('/produtos/cadastrar',[ProductController::class,'store'])->name('admin.products.creates');
    Route::get('/produtos/cadastrar', fn() => view('/admin/products/productCreate'))->name('admin.products.create');
    Route::get('/produtos/editarProdutos/{id}',[ProductController::class,'editProducts'])->name('admin.products.edit');
    Route::post('/produtos/salvarEdicao',[ProductController::class,'update'])->name('admin.products.update');
});

Route::post('/meusProdutos/order',[ProductController::class,'changeOrder'])->middleware('auth');
Route::post('/meusProdutos/availability',[ProductController::class,'changeAvailability'])->middleware('auth');
Route::delete('/meusProdutos/delete/{id}',[ProductController::class,'destroy'])->middleware('auth');
Route::post('/pedido/confirmado',[OrderController::class,'saveBudget']);
Route::get('/pedidos/{id}',[OrderManagerController::class,'manager'])->middleware('auth');
Route::post('/pedidos/visualizar',[OrderManagerController::class,'showOrder']);
Route::post('/pedidos/atualizar',[OrderManagerController::class,'updateStatusOrder']);
Route::post('/novoBanner',[BannerController::class,'create']);
Route::get('/prestador/registrar', function () {return view('admin.services.servicesRegistration');
});
Route::post('/validaCadastroPrestador',[ServicesController::class,'create']);
Route::get('/prestador/visualizar',[ServicesController::class,'view'])->middleware('auth');
Route::get('/prestadores',[ServicesController::class,'viewAllServices']);






