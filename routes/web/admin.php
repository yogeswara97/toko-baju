<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Tambahkan route lainnya di sini bro, misalnya:
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
});


