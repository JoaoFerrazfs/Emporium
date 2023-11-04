<?php

use App\Http\Apis\v1\Auth\UserAuthController;
use App\Http\Apis\v1\Product\ProductSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/productSearch', [ProductSearchController::class,'search'])->name('productSearch')
->middleware('auth:api');

Route::post('/register', [UserAuthController::class,'register']);
Route::post('/login', [UserAuthController::class,'login']);
