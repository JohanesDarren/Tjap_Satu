@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manajemen Produk</h2>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Produk
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">Foto</th>
                        <th>Nama Produk</th>
                        <th style="width: 120px;">Harga</th>
                        <th style="width: 80px;">Stok</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $item)
                        <tr>
                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset('uploads/' . $item->gambar) }}" 
                                         alt="{{ $item->nama_produk }}" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div style="width: 60px; height: 60px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->nama_produk }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                            </td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $item->stok > 20 ? 'bg-success' : ($item->stok > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.produk.edit', $item->id_product) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $item->id_product) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada data produk. <a href="{{ route('admin.produk.create') }}">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($produk->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $produk->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
