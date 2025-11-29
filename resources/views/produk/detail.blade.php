@extends('layouts.app')

@section('title', $produk->nama_produk . ' - Tjap Satu')

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
         <img src="{{ asset('storage/' . $produk->gambar) }}" class="img-fluid rounded shadow" alt="{{ $produk->nama_produk }}">
    </div>

    <div class="col-md-6">
        <h1 class="header-title">{{ $produk->nama_produk }}</h1>
        <h3 class="text-success fw-bold my-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h3>
        
        <p class="lead">{{ $produk->deskripsi }}</p>
        <p>Stok Tersedia: <strong>{{ $produk->stok }}</strong></p>

        <a href="{{ route('cart.index', ['id' => $produk->id_product]) }}" class="btn btn-success btn-lg mt-4">
            Masukkan ke Keranjang
        </a>
        
        <a href="{{ route('produk.menu') }}" class="btn btn-outline-secondary mt-4">&laquo; Kembali ke Menu</a>
    </div>
</div>
@endsection