<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('welcome');
});

// menu route
Route::get('/menu', [ProdukController::class, 'menu'])->name('produk.menu');
Route::get('/menu/{id}', [ProdukController::class, 'show'])->name('produk.show');
// orderan route
Route::get('/pesan/{id}', [ProdukController::class, 'showOrderForm'])->name('produk.order');

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

// login
use App\Http\Controllers\AuthController;
// Order — hanya tampil jika sudah login (simulasi)
Route::get('/order', [AuthController::class, 'order'])->name('order.index');

Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup.show');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.attempt');