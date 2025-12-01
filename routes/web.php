<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthFlowController;

Route::get('/', [LandingController::class, 'index'])->name('home');

// Menu
Route::get('/menu', [ProdukController::class, 'menu'])->name('produk.menu');
Route::get('/menu/{id}', [ProdukController::class, 'show'])->name('produk.show');

// ====== ADMIN AUTH ======
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ====== ADMIN PAGES (protected) ======
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('produk', AdminProdukController::class)->names('produk')->parameters(['produk' => 'id']);

    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::put('/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    Route::get('/report', [AdminReportController::class, 'index'])->name('report.index');

    Route::get('/pelanggan', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/pelanggan/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::delete('/pelanggan/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/konten', [ContentController::class, 'index'])->name('content.index');
    Route::post('/konten/banner', [ContentController::class, 'storeBanner'])->name('content.banner.store');
    Route::post('/konten/banner/{banner}', [ContentController::class, 'updateBanner'])->name('content.banner.update');
    Route::delete('/konten/banner/{banner}', [ContentController::class, 'deleteBanner'])->name('content.banner.delete');

    Route::post('/konten/promo', [ContentController::class, 'storePromo'])->name('content.promo.store');
    Route::post('/konten/promo/{promo}', [ContentController::class, 'updatePromo'])->name('content.promo.update');
    Route::delete('/konten/promo/{promo}', [ContentController::class, 'deletePromo'])->name('content.promo.delete');

    Route::post('/konten/blog', [ContentController::class, 'storeBlog'])->name('content.blog.store');
    Route::post('/konten/blog/{blog}', [ContentController::class, 'updateBlog'])->name('content.blog.update');
    Route::delete('/konten/blog/{blog}', [ContentController::class, 'deleteBlog'])->name('content.blog.delete');
});

// About
Route::get('/about', [AboutController::class, 'index'])->name('tentang');

// ====== CUSTOMER AUTH-PROTECTED ======
// Izinkan admin mengakses halaman profile
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/profile/order/{id}', [ProfileController::class, 'detailOrder'])->name('profile.order.detail');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

// Blokir admin dari akses halaman customer umum (cart/checkout)
Route::middleware(['auth:customer', 'customer_non_admin'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id_product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id_item}', [CartController::class, 'deleteItem'])->name('cart.remove');
    Route::get('/cart/update/{id_item}/{action}', [CartController::class, 'updateQuantity'])->name('cart.update');

    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});

// ====== CUSTOMER AUTH (login/register) ======
Route::get('/login', function(){ return redirect()->route('home', ['login' => 1]); })->name('login');
Route::post('/login', [AuthFlowController::class, 'submitLogin'])->name('login.submit');
Route::get('/register', [AuthFlowController::class, 'showRegister'])->name('register.page');
Route::post('/register', [AuthFlowController::class, 'submitRegister'])->name('register.submit');
