<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\RajaOngkirController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [CustomerController::class, 'index'])->name('home');

Route::prefix('products')->name('customer.products.')->group(function () {
    Route::get('/', [App\Http\Controllers\Customer\ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [App\Http\Controllers\Customer\ProductController::class, 'show'])->name('show');
});



// Auth routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'registrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'registration'])->name('register.post');

// CUSTOMER Routes (Hanya untuk role: user/customer)
Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::prefix('cart')->name('customer.cart.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\CartController::class, 'index'])->name('index');
        Route::post('/add', [App\Http\Controllers\Customer\CartController::class, 'store'])->name('store');
        Route::put('/{cart}', [App\Http\Controllers\Customer\CartController::class, 'update'])->name('update');
        Route::delete('/{cart}', [App\Http\Controllers\Customer\CartController::class, 'destroy'])->name('destroy');

        // Promo routes (masih di bawah /cart)
        Route::post('/apply-promo', [App\Http\Controllers\Customer\PromoController::class, 'apply'])->name('applyPromo');
        Route::post('/remove-promo', [App\Http\Controllers\Customer\PromoController::class, 'remove'])->name('removePromo');
    });

    Route::prefix('checkout')->name('customer.checkout.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('index');
        Route::post('/set-address', [App\Http\Controllers\Customer\CheckoutController::class, 'setAddress'])->name('set-address');
    });

    Route::get('/search-destination', [RajaOngkirController::class, 'searchDestination'])->name('customer.search-destination');
    Route::post('/cek-ongkir', [RajaOngkirController::class, 'cekOngkir'])->name('customer.cek-ongkir');

    Route::resource('address', AddressController::class);
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::get('/profile/orders/{slug}', [CustomerController::class, 'orders'])->name('profile.order');
});

Route::post('/checkout/cek-ongkir', [RajaOngkirController::class, 'cekOngkir'])->name('cek.ongkir');

// ADMIN Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    // Tambahin admin routes lainnya di sini
});
