<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HelpCaseController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\CaseUpdateController;
use App\Http\Controllers\Api\NotificationController;

// Public
Route::post('/login', [AuthController::class, 'login']);

// Register (admin only — protected)
Route::middleware('auth:sanctum')->post('/register', [AuthController::class, 'register']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    Route::apiResource('categories',   CategoryController::class);
    Route::apiResource('cases',        HelpCaseController::class);
    Route::apiResource('donations',    DonationController::class);
    Route::apiResource('case-updates', CaseUpdateController::class);

    Route::get('/team', [AuthController::class, 'team']);

    Route::get('/notifications',              [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read',   [NotificationController::class, 'markRead']);
    Route::post('/notifications/read-all',    [NotificationController::class, 'markAllRead']);
});
