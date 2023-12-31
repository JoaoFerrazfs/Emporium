<?php

use App\Http\Controllers\Checkout\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','adminUser'])->prefix('admin')->group(function () {

    Route::get('/', fn() => redirect('/admin/produtos'))
        ->name('admin');
    Route::get('/pedidos', [OrderController::class,'index'])
        ->name('admin.orders');
    Route::get('/pedido/{id}', [OrderController::class,'showOrderDetail'])
        ->name('admin.show.order');
    Route::get('/produtos', fn() => view('/admin/products/home'))
        ->name('admin.products');
    Route::get('/produtos/lista', [ProductController::class,'myProducts'])
        ->name('admin.products.list');
    Route::post('/produtos/cadastrar', [ProductController::class,'store'])
        ->name('admin.products.creates');
    Route::get('/produtos/cadastrar', fn() => view('/admin/products/productCreate'))
        ->name('admin.products.create');
    Route::get('/produtos/editarProdutos/{id}', [ProductController::class,'editProducts'])
        ->name('admin.products.edit');
    Route::get('/produtos/deletarProdutos/{id}', [ProductController::class,'deleteProducts'])
        ->name('admin.products.delete');
    Route::post('/produtos/salvarEdicao', [ProductController::class,'update'])
        ->name('admin.products.update');
});
