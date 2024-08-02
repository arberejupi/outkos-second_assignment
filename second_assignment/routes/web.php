<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ReplyController;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::middleware('web')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// User Details routes
Route::get('user-details/create', [UserDetailController::class, 'create'])->name('user-details.create');
Route::post('user-details', [UserDetailController::class, 'store'])->name('user-details.store');

// Protected routes with JWT authentication
Route::middleware(['jwt.auth'])->group(function () {
    // User profile route
    Route::get('user/profile', [AuthController::class, 'profile']);

    // Course routes
    Route::post('courses', [CourseController::class, 'store']);
    Route::delete('courses/{id}', [CourseController::class, 'destroy']);

    // Enrollment routes
    Route::post('courses/{courseId}/enroll', [EnrollmentController::class, 'enroll']);
    Route::post('courses/{courseId}/withdraw', [EnrollmentController::class, 'withdraw']);

     // Thread routes
     Route::post('threads', [ThreadController::class, 'store']);
     Route::delete('threads/{id}', [ThreadController::class, 'destroy']);
     Route::get('threads', [ThreadController::class, 'index']);
 
     // Reply routes
     Route::post('replies', [ReplyController::class, 'store']);
     Route::delete('replies/{id}', [ReplyController::class, 'destroy']);
});
