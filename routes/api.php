<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:api')->group(function () {
        // Auth
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        Route::get('/auth/profile', [AuthController::class, 'profile']);

        // Services CRUD
        Route::apiResource('services', ServiceController::class);

        // Orders CRUD
        Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);
        Route::apiResource('orders', OrderController::class);

        // Dashboard Stats
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    });
});
