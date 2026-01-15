<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    // 🔓 Public
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/refresh', [AuthController::class, 'refresh']);

    // 🔐 Protected (JWT required)
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware(['auth:api'])->group(function () {

    // Admin-only users CRUD
    Route::middleware('role:admin')->group(function () {
        Route::get('/users',        [UserController::class, 'index']);
        Route::post('/users',       [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });

});
