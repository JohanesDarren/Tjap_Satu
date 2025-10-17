@extends('layouts.app')

@section('content')
    <div class="text-center mb-5">
        <h1>Menu Kopi Tjap Satu</h1>
        <p class="lead">Nikmati pilihan biji kopi terbaik dari kami.</p>
    </div>

    <div class="row">
        @forelse($produk as $p)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://placehold.co/600x400/555555/FFFFFF?text={{ urlencode($p['nama']) }}" class="card-img-top" alt="{{ $p['nama'] }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $p['nama'] }}</h5>
                        <p class="card-text">{{ Str::limit($p['deskripsi'], 50) }}</p>
                        <h6 class="card-subtitle mb-2 text-muted">Rp {{ number_format($p['harga'], 0, ',', '.') }}</h6>
                        <a href="{{ route('produk.show', ['id' => $p['id']]) }}" class="btn btn-primary mt-auto">See more</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p class="text-center">Belum ada produk yang tersedia.</p>
            </div>
        @endforelse
    </div>
@endsection