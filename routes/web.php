<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/menu/{id}', [ProdukController::class, 'show'])->name('produk.show');