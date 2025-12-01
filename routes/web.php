<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthFlowController;

Route::get('/', [LandingController::class, 'index'])->name('home');

// Menu
Route::prefix('menu')->name('produk.')->group(function () {
    Route::get('/', [ProdukController::class, 'menu'])->name('menu');
    Route::get('{id}', [ProdukController::class, 'show'])->name('show');
});

// Admin (auth + protected)
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected pages
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('produk', AdminProdukController::class)
            ->names('produk')
            ->parameters(['produk' => 'id']);

        Route::prefix('pesanan')->name('pesanan.')->group(function () {
            Route::get('/', [AdminPesananController::class, 'index'])->name('index');
            Route::put('{id}/status', [AdminPesananController::class, 'updateStatus'])->name('updateStatus');
        });

        Route::get('report', [AdminReportController::class, 'index'])->name('report.index');

        Route::prefix('pelanggan')->name('customers.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('{id}', [CustomerController::class, 'show'])->name('show');
            Route::delete('{id}', [CustomerController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('konten')->name('content.')->group(function () {
            Route::get('/', [ContentController::class, 'index'])->name('index');

            Route::prefix('banner')->name('banner.')->group(function () {
                Route::post('/', [ContentController::class, 'storeBanner'])->name('store');
                Route::post('{banner}', [ContentController::class, 'updateBanner'])->name('update');
                Route::delete('{banner}', [ContentController::class, 'deleteBanner'])->name('delete');
            });

            Route::prefix('promo')->name('promo.')->group(function () {
                Route::post('/', [ContentController::class, 'storePromo'])->name('store');
                Route::post('{promo}', [ContentController::class, 'updatePromo'])->name('update');
                Route::delete('{promo}', [ContentController::class, 'deletePromo'])->name('delete');
            });

            Route::prefix('blog')->name('blog.')->group(function () {
                Route::post('/', [ContentController::class, 'storeBlog'])->name('store');
                Route::post('{blog}', [ContentController::class, 'updateBlog'])->name('update');
                Route::delete('{blog}', [ContentController::class, 'deleteBlog'])->name('delete');
            });
        });
    });
});

// About
Route::get('/about', [AboutController::class, 'index'])->name('tentang');

// Customer auth-protected (admin allowed)
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/profile/order/{id}', [ProfileController::class, 'detailOrder'])->name('profile.order.detail');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

// Customer only (non-admin)
Route::middleware(['auth:customer', 'customer_non_admin'])->group(function () {
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('process', [CheckoutController::class, 'process'])->name('process');
        Route::get('success', [CheckoutController::class, 'success'])->name('success');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('add/{id_product}', [CartController::class, 'addToCart'])->name('add');
        Route::delete('remove/{id_item}', [CartController::class, 'deleteItem'])->name('remove');
        Route::get('update/{id_item}/{action}', [CartController::class, 'updateQuantity'])->name('update');
    });

    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});

// Customer auth (login/register)
Route::get('/login', fn () => redirect()->route('home', ['login' => 1]))->name('login');
Route::post('/login', [AuthFlowController::class, 'submitLogin'])->name('login.submit');
Route::get('/register', [AuthFlowController::class, 'showRegister'])->name('register.page');
Route::post('/register', [AuthFlowController::class, 'submitRegister'])->name('register.submit');
