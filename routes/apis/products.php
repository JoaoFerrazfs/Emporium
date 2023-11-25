<?php

use App\Http\Apis\v1\Product\ProductSearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->middleware('api.cache')->group(function () {

    Route::post('/search', [ProductSearchController::class,'search'])->name('productSearch');
    Route::post('/list', [ProductSearchController::class,'listAvailableProducts'])->name('productSearch');
});

