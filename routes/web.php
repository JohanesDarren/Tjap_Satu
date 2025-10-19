<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/menu/{id}', [ProdukController::class, 'show'])->name('produk.show');

// About Page Route
use App\Http\Controllers\AboutController;
Route::get('/about', [AboutController::class, 'index']);

// Cart Page Route
use App\Http\Controllers\CartController;
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Checkout Page Routes
use App\Http\Controllers\CheckoutController;
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');