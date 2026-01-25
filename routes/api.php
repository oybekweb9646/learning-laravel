<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {

    // 🔓 Public
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/refresh', [AuthController::class, 'refresh']);

    // 🔐 Protected
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/news', [NewsController::class, 'index'])
    ->name('news.index');

Route::get('/news/{news}', [NewsController::class, 'show'])
    ->name('news.show');

Route::get('/files/{uuid}', [FileController::class, 'show'])
    ->name('files.show');

Route::get('/files/{uuid}/download', [FileController::class, 'download'])
    ->name('files.download');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:api'])->group(function () {

    // 👮‍♂️ Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });

    // 📁 Files
    Route::post('/files', [FileController::class, 'store'])
        ->name('files.store');

    // 📰 News (protected CRUD)
    Route::post('/news', [NewsController::class, 'store'])
        ->name('news.store');

    Route::put('/news/{news}', [NewsController::class, 'update'])
        ->name('news.update');

    Route::patch('/news/{news}', [NewsController::class, 'update']);

    Route::delete('/news/{news}', [NewsController::class, 'destroy'])
        ->name('news.destroy');
});
