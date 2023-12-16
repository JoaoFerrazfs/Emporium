<?php

use App\Http\Apis\v1\Product\ProductController;
use App\Http\Apis\v1\Product\ProductSearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::post('/', [ProductController::class,'store'])->name('createProduct');

    Route::middleware('api.cache')->group(function () {

        Route::post('/search', [ProductSearchController::class,'search'])->name('product.search');
        Route::post('/list', [ProductSearchController::class,'listAvailableProducts'])->name('available.products');
    });
});



