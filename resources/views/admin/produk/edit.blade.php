@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Edit Produk</h3>
    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.produk.update', $produk->id_product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" value="{{ old('harga', $produk->harga) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok) }}" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Gambar Produk (Opsional)</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>

                    @if($produk->gambar)
                        <div class="mt-2">
                            <img src="{{ asset('uploads/' . $produk->gambar) }}" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Perbarui Produk</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
