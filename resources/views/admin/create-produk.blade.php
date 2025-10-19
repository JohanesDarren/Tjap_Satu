@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container">
    <h1 class="header-title mb-4">Tambah Produk Baru</h1>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.produk.store') }}" method="POST">
                @csrf
                {{-- Di sini kita bisa include form partial jika formnya kompleks --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                {{-- Tambahkan field lainnya sesuai kebutuhan --}}
                <button type="submit" class="btn btn-success">Simpan Produk</button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection