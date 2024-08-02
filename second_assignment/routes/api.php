<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDetailController;

Route::middleware(\App\Http\Middleware\JWTAuthenticate::class)->group(function () {
    Route::get('user/profile', [AuthController::class, 'profile']);
});

Route::middleware('api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
