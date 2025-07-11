<?php

use Illuminate\Support\Facades\Route;

// === Auth Routes ===
require __DIR__.'/web/auth.php';

// === CUSTOMER Routes (auth + role: customer) ===
require __DIR__.'/web/customer.php';

// === ADMIN Routes ===
require __DIR__.'/web/admin.php';

// === Alert Clear Routes ===
Route::post('/alert/clear', function () {
    session()->forget(['success', 'error', 'warning', 'info']);
    return response()->json(['cleared' => true]);
})->name('alert.clear');

// === 404 Routes ===
Route::fallback(function () {
    return redirect()->route('customer.home');
});
