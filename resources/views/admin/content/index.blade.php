@extends('layouts.admin')

@section('content')
<h2 class="mb-4">Manajemen Konten</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <ul class="nav nav-tabs card-header-tabs" id="contentTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#banner" type="button">Banner Utama</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#promo" type="button">Promo</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#blog" type="button">Blog / Artikel</button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="contentTabsContent">
            
            <div class="tab-pane fade show active" id="banner" role="tabpanel">
                <form action="{{ route('admin.content.banner.store') }}" method="POST" enctype="multipart/form-data" class="mb-4 p-3 bg-light rounded">
                    @csrf
                    <h6>Tambah Banner Baru</h6>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="title" class="form-control" placeholder="Judul Banner" required>
                        </div>
                        <div class="col-md-4">
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Upload Banner</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    @foreach($banners as $banner)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <img src="{{ asset('storage/'.$banner->image_path) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ $banner->title }}</h6>
                                <form action="{{ route('admin.content.banner.delete', $banner->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger w-100">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="tab-pane fade" id="promo" role="tabpanel">
                <form action="{{ route('admin.content.promo.store') }}" method="POST" class="mb-4 p-3 bg-light rounded">
                    @csrf
                    <h6>Buat Promo Baru</h6>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="title" class="form-control" placeholder="Nama Promo" required>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">Simpan</button>
                        </div>
                        <div class="col-12 mt-2">
                            <textarea name="description" class="form-control" placeholder="Deskripsi Promo" rows="2"></textarea>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead><tr><th>Promo</th><th>Periode</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($promos as $promo)
                        <tr>
                            <td>{{ $promo->title }}</td>
                            <td>{{ $promo->start_date->format('d M') }} - {{ $promo->end_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $promo->active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $promo->active ? 'Aktif' : 'Non-aktif' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.content.promo.delete', $promo->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="blog" role="tabpanel">
                <form action="{{ route('admin.content.blog.store') }}" method="POST" enctype="multipart/form-data" class="mb-4 p-3 bg-light rounded">
                    @csrf
                    <h6>Tulis Artikel Baru</h6>
                    <div class="mb-2">
                        <input type="text" name="title" class="form-control" placeholder="Judul Artikel" required>
                    </div>
                    <div class="mb-2">
                        <textarea name="content" class="form-control" rows="3" placeholder="Isi artikel..." required></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="file" name="cover" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100">Publish</button>
                        </div>
                    </div>
                </form>

                <div class="list-group">
                    @foreach($blogs as $blog)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $blog->title }}</h6>
                            <small class="text-muted">{{ Str::limit($blog->content, 100) }}</small>
                        </div>
                        <form action="{{ route('admin.content.blog.delete', $blog->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection