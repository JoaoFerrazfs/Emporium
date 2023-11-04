<?php

use App\Http\Apis\v1\Product\ProductSearchController;

Route::post('/productSearch', [ProductSearchController::class,'search'])->name('productSearch')
    ->middleware('auth:api');
