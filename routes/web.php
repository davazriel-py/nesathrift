<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Beranda sementara (diganti HomeController di Tahap 3)
Route::view('/', 'home')->name('home');

// Detail barang (publik)
Route::get('/barang/{product}', [ProductController::class, 'show'])
    ->whereNumber('product')->name('products.show');

// Hanya untuk tamu
Route::middleware('guest')->group(function () {
    Route::get('/daftar', [RegisterController::class, 'create'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'store'])->middleware('throttle:10,1');

    Route::get('/masuk', [LoginController::class, 'create'])->name('login');
    Route::post('/masuk', [LoginController::class, 'store'])->middleware('throttle:10,1');
});

// Harus login
Route::middleware('auth')->group(function () {
    Route::post('/keluar', [LoginController::class, 'destroy'])->name('logout');

    // Verifikasi OTP
    Route::get('/verifikasi-otp', [OtpController::class, 'show'])->name('otp.notice');
    Route::post('/verifikasi-otp', [OtpController::class, 'verify'])->middleware('throttle:6,1')->name('otp.verify');
    Route::post('/kirim-ulang-otp', [OtpController::class, 'resend'])->middleware('throttle:3,1')->name('otp.resend');

    // Harus login DAN sudah verifikasi OTP
    Route::middleware('otp.verified')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/barang/tambah', [ProductController::class, 'create'])->name('products.create');
        Route::post('/barang', [ProductController::class, 'store'])->middleware('throttle:20,1')->name('products.store');
        Route::get('/barang/{product}/edit', [ProductController::class, 'edit'])->whereNumber('product')->name('products.edit');
        Route::put('/barang/{product}', [ProductController::class, 'update'])->whereNumber('product')->name('products.update');
        Route::delete('/barang/{product}', [ProductController::class, 'destroy'])->whereNumber('product')->name('products.destroy');
    });
});