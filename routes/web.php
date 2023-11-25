<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require __DIR__ . '/auth.php';

/**
 * Ecommerce free routes
 */
include_once __DIR__.'/ecommerce/routes.php';

/**
 * Admin control access routes
 */
include_once __DIR__.'/admin/routes.php';



