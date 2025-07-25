<?php

use Illuminate\Support\Facades\Route;

Route::name('customer.')->group(function () {

    Route::get('/', [\App\Http\Controllers\Customer\CustomerController::class, 'index'])->name('home');

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\ProductController::class, 'index'])->name('index');
        Route::get('/{slug}', [\App\Http\Controllers\Customer\ProductController::class, 'show'])->name('show');
    });

    Route::middleware(['auth', 'role:admin,customer'])->group(function () {

        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\CartController::class, 'index'])->name('index');
            Route::post('/add', [\App\Http\Controllers\Customer\CartController::class, 'store'])->name('store');
            Route::put('/{cart}', [\App\Http\Controllers\Customer\CartController::class, 'update'])->name('update');
            Route::delete('/{cart}', [\App\Http\Controllers\Customer\CartController::class, 'destroy'])->name('destroy');

            Route::post('/apply-promo', [\App\Http\Controllers\Customer\PromoController::class, 'apply'])->name('applyPromo');
            Route::post('/remove-promo', [\App\Http\Controllers\Customer\PromoController::class, 'remove'])->name('removePromo');
        });

        Route::prefix('checkout')->name('checkout.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('index');
            Route::post('/set-address', [\App\Http\Controllers\Customer\CheckoutController::class, 'setAddress'])->name('set-address');
            Route::post('/order', [\App\Http\Controllers\Customer\CheckoutController::class, 'order'])->name('order');
            Route::get('/status/{status}/{order_code}', [\App\Http\Controllers\Customer\CheckoutController::class, 'status'])->name('status');
        });

        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('/payment', [\App\Http\Controllers\Customer\PaymentController::class, 'pay'])->name('pay');
            Route::post('/payment/cancel', [\App\Http\Controllers\Customer\PaymentController::class, 'cancel'])->name('cancel');
        });

        Route::resource('address', \App\Http\Controllers\Customer\AddressController::class);

        Route::prefix('shipping')->group(function () {
            Route::get('/search-destination', [\App\Http\Controllers\Customer\RajaOngkirController::class, 'searchDestination'])->name('search-destination');
            Route::post('/cek-ongkir', [\App\Http\Controllers\Customer\RajaOngkirController::class, 'cekOngkir'])->name('cek-ongkir');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\CustomerController::class, 'profile'])->name('index');
            Route::get('/order/{order_code}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('order');

            Route::get('/edit', [\App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [\App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('update');
            Route::post('/delete-image', [\App\Http\Controllers\Customer\ProfileController::class, 'deleteImage'])->name('delete-image');

        });
    });
});
