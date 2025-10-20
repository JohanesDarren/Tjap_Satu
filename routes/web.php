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

    // Banner
    Route::post('/konten/banner', [ContentController::class, 'storeBanner'])->name('content.banner.store');
    Route::post('/konten/banner/{id}', [ContentController::class, 'updateBanner'])->name('content.banner.update');
    Route::delete('/konten/banner/{id}', [ContentController::class, 'deleteBanner'])->name('content.banner.delete');

    // Promo
    Route::post('/konten/promo', [ContentController::class, 'storePromo'])->name('content.promo.store');
    Route::post('/konten/promo/{id}', [ContentController::class, 'updatePromo'])->name('content.promo.update');
    Route::delete('/konten/promo/{id}', [ContentController::class, 'deletePromo'])->name('content.promo.delete');

    // Blog 
    Route::post('/konten/blog', [ContentController::class, 'storeBlog'])->name('content.blog.store');
    Route::post('/konten/blog/{id}', [ContentController::class, 'updateBlog'])->name('content.blog.update');
    Route::delete('/konten/blog/{id}', [ContentController::class, 'deleteBlog'])->name('content.blog.delete');

    // Produk Admin
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
});


// About Page Route
use App\Http\Controllers\AboutController;

Route::get('/about', [AboutController::class, 'index'])->name('tentang');

// Cart Page Route
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Checkout Page Routes
use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Profile Page Route
//profile
use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// === LOGIN FLOW (tanpa auth logic) ===

// buka popup login di mana saja via #loginModal
Route::post('/login', function () {
    // langsung redirect ke halaman home
    return redirect()->route('home')->with('user', true);
})->name('login.submit');

// ====== LOGIN (tanpa logic, hanya redirect balik ke home) ======
use App\Http\Controllers\AuthFlowController;

Route::post('/login', [AuthFlowController::class, 'submitLogin'])->name('login.submit');

// ====== REGISTER ======
Route::get('/register', [AuthFlowController::class, 'showRegister'])->name('register.page');
Route::post('/register', [AuthFlowController::class, 'submitRegister'])->name('register.submit');