<?php

use App\Http\Controllers\Customer\RajaOngkirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/rajaongkir/destination', [RajaOngkirController::class, 'searchDestination'])->name('rajaongkir.destination');
Route::get('/rajaongkir/ongkir', [RajaOngkirController::class, 'checkOngkir'])->name('rajaongkir.ongkir');
