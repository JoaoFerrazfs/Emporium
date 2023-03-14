<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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






