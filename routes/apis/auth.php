<?php

use App\Http\Apis\v1\Auth\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserAuthController::class,'register']);
Route::post('/login', [UserAuthController::class,'login']);
