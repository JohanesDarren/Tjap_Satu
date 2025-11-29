<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('home');


// menu route
Route::get('/menu', [ProdukController::class, 'menu'])->name('produk.menu');
Route::get('/menu/{id}', [ProdukController::class, 'show'])->name('produk.show');
//admin pesanan route
Route::get('/admin/pesanan', [AdminPesananController::class, 'index'])->name('admin.pesanan.index');
//admin report route
Route::get('/admin/report', [AdminReportController::class, 'index'])->name('admin.report.index');

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ContentController;
// admin produk route
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //pelanggan route
    Route::get('/pelanggan', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/pelanggan/{id}', [CustomerController::class, 'show'])->name('customers.show');

    // Halaman CMS
    Route::get('/konten', [ContentController::class, 'index'])->name('content.index');

    // Banner (CRUD, route model binding)
    Route::post('/konten/banner', [ContentController::class, 'storeBanner'])->name('content.banner.store');
    Route::post('/konten/banner/{banner}', [ContentController::class, 'updateBanner'])->name('content.banner.update');
    Route::delete('/konten/banner/{banner}', [ContentController::class, 'deleteBanner'])->name('content.banner.delete');

    // Promo (CRUD)
    Route::post('/konten/promo', [ContentController::class, 'storePromo'])->name('content.promo.store');
    Route::post('/konten/promo/{promo}', [ContentController::class, 'updatePromo'])->name('content.promo.update');
    Route::delete('/konten/promo/{promo}', [ContentController::class, 'deletePromo'])->name('content.promo.delete');

    // Blog (CRUD, route model binding)
    Route::post('/konten/blog', [ContentController::class, 'storeBlog'])->name('content.blog.store');
    Route::post('/konten/blog/{blog}', [ContentController::class, 'updateBlog'])->name('content.blog.update');
    Route::delete('/konten/blog/{blog}', [ContentController::class, 'deleteBlog'])->name('content.blog.delete');

    // Produk Admin
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
});

//========== PUNYA AFDIKKKKKK ============//

// About Page Route
use App\Http\Controllers\AboutController;
Route::get('/about', [AboutController::class, 'index'])->name('tentang');

// Cart Page Route
use App\Http\Controllers\CartController;
// Checkout Page Routes
use App\Http\Controllers\CheckoutController;
// Profile Page Route
use App\Http\Controllers\ProfileController;

Route::middleware('auth:customer')->group(function () {
    // Checkout protected
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    //cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id_product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id_item}', [CartController::class, 'deleteItem'])->name('cart.remove');
    Route::get('/cart/update/{id_item}/{action}', [CartController::class, 'updateQuantity'])->name('cart.update');

    // Profile protected
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/profile/order/{id}', [ProfileController::class, 'detailOrder'])->name('profile.order.detail');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    // Logout
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});

// ====== LOGIN / REGISTER ======
use App\Http\Controllers\AuthFlowController;
Route::get('/login', function(){ return redirect()->route('home', ['login' => 1]); })->name('login');
Route::post('/login', [AuthFlowController::class, 'submitLogin'])->name('login.submit');
Route::get('/register', [AuthFlowController::class, 'showRegister'])->name('register.page');
Route::post('/register', [AuthFlowController::class, 'submitRegister'])->name('register.submit');
