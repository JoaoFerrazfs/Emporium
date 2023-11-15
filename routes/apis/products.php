<?php

use App\Http\Apis\v1\Product\ProductSearchController;

Route::prefix('products')->group(function () {

    Route::post('/search', [ProductSearchController::class,'search'])->name('productSearch');
    Route::post('/list', [ProductSearchController::class,'listAvailableProducts'])->name('productSearch');
});

