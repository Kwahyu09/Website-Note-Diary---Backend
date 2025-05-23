<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriKeuanganController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\RekapBulananController;
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

    //kategori keuangan
    Route::apiResource('kategori', KategoriKeuanganController::class);

    //keuangan
    Route::apiResource('keuangan', KeuanganController::class);

    //rekap
    Route::post('rekap/simpan', [RekapBulananController::class, 'hitungRekap']);
    Route::get('grafik/kategori', [RekapBulananController::class, 'grafikKategori']);
    Route::get('saldo', [RekapBulananController::class, 'getRingkasanKeuangan']);
});