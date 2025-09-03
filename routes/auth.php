<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

Route::prefix('auth')->name('auth.')->middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('forgot-password');
    Route::post('/forgot-password', 'sendResetEmail');
    Route::post('/logout', 'logout')->withoutMiddleware('guest')->middleware('auth')->name('logout');
});

// Laravel'in beklediği password reset route'ları (auth prefix'i olmadan)
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});