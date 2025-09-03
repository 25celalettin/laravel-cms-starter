<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LanguageController;


Route::get('/', fn() => 'hello!')->name('website.home');

// Auth Routes
require_once __DIR__ . '/auth.php';

// Admin Routes
require_once __DIR__ . '/admin.php';

// Dil değiştirme route'u
Route::post('/language/change', [LanguageController::class, 'changeLanguage'])->name('language.change');