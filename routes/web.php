<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;

Route::get('/', function () {
    return view('welcome');
});

// menu route
Route::get('/menu', [ProdukController::class, 'menu'])->name('produk.menu');
Route::get('/menu/{id}', [ProdukController::class, 'show'])->name('produk.show');
// orderan route
Route::get('/pesan/{id}', [ProdukController::class, 'showOrderForm'])->name('produk.order');
// admin produk route
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
});

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