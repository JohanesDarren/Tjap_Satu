@extends('layouts.main')

@section('title', ($produk['nama'] ?? 'Produk') . ' - Tjap Satu')

@section('content')
<style>
    :root {
        --tjap-green: #2E7D6D;
        --tjap-dark-blue: #1B2A41;
    }
    .header-title { 
        font-family: 'Playfair Display', serif; 
        color: var(--tjap-dark-blue);
    }
    .btn-success {
        background-color: var(--tjap-green);
        border-color: var(--tjap-green);
    }
    .btn-success:hover {
        background-color: #1f5a51;
    }
</style>

<div class="container my-5">
     <div class="row">
         <div class="col-md-6 mb-4">
             <img src="{{ asset($produk['gambar'] ?? 'images/placeholder.jpg') }}" class="img-fluid rounded shadow" alt="{{ $produk['nama'] ?? 'Produk' }}" style="max-height: 400px; object-fit: cover;">
         </div>

         <div class="col-md-6">
             <h1 class="header-title">{{ $produk['nama'] ?? 'Nama Produk' }}</h1>
             <h3 class="text-success fw-bold my-3">Rp {{ number_format($produk['harga']['100gr'] ?? 0, 0, ',', '.') }}</h3>
             
             <p class="lead">{{ $produk['proses'] ?? 'Deskripsi tidak tersedia' }}</p>
             <p class="mb-4">
                 <strong>Jenis Kopi:</strong> {{ $produk['jenis'] ?? '-' }}<br>
                 <strong>Proses:</strong> {{ $produk['proses'] ?? '-' }}
             </p>

             <a href="{{ route('produk.menu') }}" class="btn btn-success btn-lg mt-4">
                 <i class="bi bi-cart-plus me-2"></i> Masukkan ke Keranjang
             </a>
             
             <a href="{{ route('produk.menu') }}" class="btn btn-outline-secondary btn-lg mt-2">
                 <i class="bi bi-arrow-left me-2"></i> Kembali ke Menu
             </a>
         </div>
     </div>
</div>
@endsection