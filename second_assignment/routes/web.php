<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\TestController;

// Welcome Route
Route::get('/', function () {
    return view('welcome');
});
Route::get('/log-test', [TestController::class, 'logTest']);


// Register Route
Route::post('register', [AuthController::class, 'register']);

// Login Route
Route::post('login', [AuthController::class, 'login']);

// Protected Route with JWT Authentication
Route::middleware(['jwt.auth'])->group(function () {
    Route::get('user/profile', [AuthController::class, 'profile']);
});
