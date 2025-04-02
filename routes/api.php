<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // user
    Route::controller(UserController::class)->group(function () {
        Route::get('user', 'index');
        Route::get('user/{id}', 'show');
        Route::delete('user/{id}', 'destroy');
        Route::post('user', 'store');
    });
});