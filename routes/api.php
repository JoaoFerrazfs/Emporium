<?php
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    /**
     * Auth routes
     */
    include_once __DIR__.'/apis/auth.php';

    /**
     * Products routes
     */
    include_once __DIR__.'/apis/products.php';

    /**
     * Reports routes
     */
    include_once __DIR__.'/apis/reports.php';
});


