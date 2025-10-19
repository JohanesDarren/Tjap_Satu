@extends('layouts.app')
@section('title', 'Product Management')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="header-title">Product Management</h1>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Produk Baru
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Proses</th>
                        <th scope="col">Harga (100gr)</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $produk)
                        <tr>
                            <th scope="row">{{ $produk['id'] }}</th>
                            <td>{{ $produk['nama'] }}</td>
                            <td><span class="badge bg-secondary">{{ $produk['jenis'] }}</span></td>
                            <td>{{ $produk['proses'] }}</td>
                            <td>Rp {{ number_format($produk['harga']['100gr'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.produk.edit', $produk['id']) }}" class="btn btn-sm btn-primary" title="Edit">
                                     <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.produk.destroy', $produk['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection