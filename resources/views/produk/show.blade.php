@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
             <img src="https://placehold.co/600x400/555555/FFFFFF?text={{ urlencode($produk['nama']) }}" class="img-fluid rounded" alt="{{ $produk['nama'] }}">
        </div>
        <div class="col-md-6">
            <h1>{{ $produk['nama'] }}</h1>
            <p class="lead">{{ $produk['deskripsi'] }}</p>
            <h3 class="text-primary">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</h3>
            <hr>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">&laquo; Back to Menu</a>
        </div>
    </div>
@endsection