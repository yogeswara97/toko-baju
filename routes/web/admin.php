<?php

use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Resource lainnya
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    // === 🔐 Admin Profile ===
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/delete-image', [ProfileController::class, 'deleteImage'])->name('delete-image');
    });
});
