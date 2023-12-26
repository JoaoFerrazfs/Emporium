<?php

use App\Http\Apis\v1\Product\ProductReportsController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->group(function () {

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductReportsController::class,'exportProducts'])->name('products.report');
    });
});
