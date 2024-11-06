<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'index'])->name('home');


//APIs
Route::prefix('api')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
   
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('order')->group(function () {
            Route::post('/', [OrderController::class, 'create'])->name('order.create');
            Route::get('/{limit}', [OrderController::class, 'getAll'])->name('order');
        });

        Route::prefix('products')->group(function () {
            Route::get('/{limit}', [ProductController::class, 'getAll'])->name('products')->where('limit', '[0-9]+');
        });
    });
});
