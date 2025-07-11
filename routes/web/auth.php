<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [App\Http\Controllers\AuthController::class, 'registrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'registration'])->name('register.post');
});

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');
