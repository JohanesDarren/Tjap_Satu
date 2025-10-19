@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container">
    <h1 class="header-title mb-4">Edit Produk: {{ $produk['nama'] }}</h1>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.produk.update', $produk['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $produk['nama'] }}" required>
                </div>
                {{-- Tambahkan field lainnya sesuai kebutuhan --}}
                <button type="submit" class="btn btn-primary">Perbarui Produk</button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection