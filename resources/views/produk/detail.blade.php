@extends('layouts.app')

@section('title', $produk['nama'] . ' - Tjap Satu')

@section('content')
<div class="row">
    {{-- Kolom Gambar --}}
    <div class="col-md-6 mb-4">
         <img src="{{ asset($produk['gambar'] ?? 'images/placeholder.jpg') }}" class="img-fluid rounded shadow" alt="{{ $produk['nama'] }}">
    </div>

    {{-- Kolom Detail --}}
    <div class="col-md-6">
        <h1 class="header-title">{{ $produk['nama'] }}</h1>
        <span class="badge bg-success fs-6 mb-3">{{ $produk['jenis'] }}</span>
        <p class="lead">{{ $produk['proses'] }}</p>

        <div class="mt-4">
            <h4>Harga:</h4>
            <ul class="list-group">
                @foreach($produk['harga'] as $berat => $harga)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>{{ $berat }}</strong>
                        <span class="fs-5">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <a href="{{ route('produk.order', ['id' => $produk['id']]) }}" class="btn btn-success btn-lg mt-4">
            Pesan Sekarang
        </a>
        
        <a href="{{ route('produk.menu') }}" class="btn btn-outline-secondary mt-4">&laquo; Kembali ke Menu</a>
    </div>
</div>
@endsection