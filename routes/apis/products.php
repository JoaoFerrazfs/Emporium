<?php

use App\Http\Apis\v1\Product\ProductController;
use App\Http\Apis\v1\Product\ProductSearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {

    Route::prefix('admin')->group(function () {
        Route::post('/', [ProductController::class,'store'])->name('create.product');
    });


    Route::middleware('api.cache')->group(function () {

        Route::get('/', [ProductController::class,'listAvailableProducts'])->name('available.products');
        Route::get('/{id}', [ProductController::class,'getProductById'])->name('product');

        Route::get('/search', [ProductSearchController::class,'search'])->name('product.search');
    });
});
