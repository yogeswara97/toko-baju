<?php

use Illuminate\Support\Facades\Route;

// === Public Routes ===
Route::get('/', [\App\Http\Controllers\Customer\CustomerController::class, 'index'])->name('home');

Route::prefix('products')->name('customer.products.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Customer\ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [\App\Http\Controllers\Customer\ProductController::class, 'show'])->name('show');
});

// === Auth Routes ===
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/register', [\App\Http\Controllers\AuthController::class, 'registrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'registration'])->name('register.post');

// === CUSTOMER Routes (auth + role: customer) ===
Route::middleware(['auth', 'role:customer'])->name('customer.')->group(function () {

    // === CART ===
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\CartController::class, 'index'])->name('index');
        Route::post('/add', [\App\Http\Controllers\Customer\CartController::class, 'store'])->name('store');
        Route::put('/{cart}', [\App\Http\Controllers\Customer\CartController::class, 'update'])->name('update');
        Route::delete('/{cart}', [\App\Http\Controllers\Customer\CartController::class, 'destroy'])->name('destroy');

        // Promo
        Route::post('/apply-promo', [\App\Http\Controllers\Customer\PromoController::class, 'apply'])->name('applyPromo');
        Route::post('/remove-promo', [\App\Http\Controllers\Customer\PromoController::class, 'remove'])->name('removePromo');
    });

    // === CHECKOUT ===
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('index');
        Route::post('/set-address', [\App\Http\Controllers\Customer\CheckoutController::class, 'setAddress'])->name('set-address');
        Route::get('/order', [\App\Http\Controllers\Customer\CheckoutController::class, 'order'])->name('order');
        Route::get('/payment', [\App\Http\Controllers\Customer\PaymentController::class, 'index'])->name('payment');
        Route::get('/checkout/status/{status}/{order_code}', [\App\Http\Controllers\Customer\CheckoutController::class, 'status'])->name('status');

    });

    // === ADDRESS ===
    Route::resource('address', \App\Http\Controllers\Customer\AddressController::class);

    // === RAJA ONGKIR ===
    Route::prefix('shipping')->group(function () {
        Route::get('/search-destination', [\App\Http\Controllers\Customer\RajaOngkirController::class, 'searchDestination'])->name('search-destination');
        Route::post('/cek-ongkir', [\App\Http\Controllers\Customer\RajaOngkirController::class, 'cekOngkir'])->name('cek-ongkir');
    });

    // === PROFILE & ORDER ===
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\CustomerController::class, 'profile'])->name('index');
        Route::get('/order/{order_code}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('order');
    });

});



// === ADMIN Routes ===
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');
    // Tambah route admin lainnya
});
