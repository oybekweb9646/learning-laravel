<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\NewsController;
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

    Route::post('/files', [FileController::class, 'store']);
    Route::get('/files/{uuid}', [FileController::class, 'download'])
        ->name('files.download');
//
//    Route::get('/news', [NewsController::class, 'index'])
//        ->name('news.index');

    Route::post('/news', [NewsController::class, 'store'])
        ->name('news.store');

    Route::get('/news/{news}', [NewsController::class, 'show'])
        ->name('news.show');

    Route::put('/news/{news}', [NewsController::class, 'update'])
        ->name('news.update');

    Route::patch('/news/{news}', [NewsController::class, 'update']);

    Route::delete('/news/{news}', [NewsController::class, 'destroy'])
        ->name('news.destroy');
});


Route::get('/news', [NewsController::class, 'index'])
    ->name('news.index');

Route::post('/files', [FileController::class, 'store'])->name('files.store');
Route::get('/files/{uuid}/download', [FileController::class, 'download'])->name('files.download');
Route::get('/files/{uuid}', [FileController::class, 'show'])->name('files.show'); // Qo'shimcha
