@extends('layouts.admin')
@section('title', 'Manajemen Konten')

@push('styles')
<style>
    .thumb-banner {
        width: 160px;
        height: 48px;
        object-fit: cover;
        border-radius: .5rem;
    }

    .table-fit td,
    .table-fit th {
        white-space: nowrap;
    }

    .modal-backdrop.show {
        opacity: 0.6 !important;
        background-color: rgba(0, 0, 0, 0.6) !important;
    }

    .modal-content {
        background-color: #ffffff !important;
        border-radius: 0.75rem;
        border: 1px solid #ddd;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .modal-body {
        background-color: #f8f9fa !important;
        border-radius: 0.5rem;
        padding: 1.25rem;
    }

    .modal-body .form-control,
    .modal-body textarea {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 0.375rem;
        transition: 0.2s;
    }

    .modal-body .form-control:focus,
    .modal-body textarea:focus {
        border-color: #1b2a41;
        box-shadow: 0 0 0 0.15rem rgba(27, 42, 65, 0.25);
    }

    .btn-dark:hover {
        background-color: #222;
        color: #fff;
    }
    .modal-dialog {
    margin-top: 10vh;
    transition: transform 0.2s ease-in-out;
}
.modal.show .modal-dialog {
    transform: scale(1.02);
}

</style>
@endpush


@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0">Manajemen Konten</h1>
        <a href="{{ url('/admin') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Dashboard
        </a>
    </div>

    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <div class="fw-semibold mb-1">Validasi gagal:</div>
            <ul class="mb-0 small">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-pills mb-3" id="cmsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="banner-tab" data-bs-toggle="pill" data-bs-target="#banner-pane"
                type="button" role="tab">Banner</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="promo-tab" data-bs-toggle="pill" data-bs-target="#promo-pane" type="button"
                role="tab">Promo</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="blog-tab" data-bs-toggle="pill" data-bs-target="#blog-pane" type="button"
                role="tab">Blog</button>
        </li>
    </ul>

    <div class="tab-content">
        {{-- ================== BANNER ================== --}}
        <div class="tab-pane fade show active" id="banner-pane" role="tabpanel" aria-labelledby="banner-tab">
            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Tambah / Update Banner</div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.content.banner.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input name="title" class="form-control" placeholder="Judul banner" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar URL</label>
                                    <input name="image_url" class="form-control" placeholder="https://..." required>
                                    <div class="form-text">Gunakan URL gambar (CDN/placeholder).</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Link (opsional)</label>
                                    <input name="link_url" class="form-control" placeholder="https://...">
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-dark"><i class="bi bi-plus-lg me-1"></i> Simpan Banner</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Daftar Banner</div>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0 table-fit">
                                <thead class="table-light">
                                    <tr>
                                        <th>Preview</th>
                                        <th>Judul</th>
                                        <th>Link</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($banners as $b)
                                        <tr>
                                            <td><img class="thumb-banner" src="{{ $b['image_url'] }}" alt=""></td>
                                            <td class="fw-semibold">{{ $b['title'] }}</td>
                                            <td class="text-truncate" style="max-width: 220px;">
                                                <a href="{{ $b['link_url'] ?? '#' }}"
                                                    target="_blank">{{ $b['link_url'] ?? '-' }}</a>
                                            </td>
                                            <td class="text-end">
                                                <!-- Modal trigger edit -->
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#editBanner-{{ $b['id'] }}">
                                                    Edit
                                                </button>
                                                <form class="d-inline" method="post"
                                                    action="{{ route('admin.content.banner.delete', $b['id']) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus banner ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editBanner-{{ $b['id'] }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post"
                                                    action="{{ route('admin.content.banner.update', $b['id']) }}"
                                                    class="modal-content">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Banner</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Judul</label>
                                                            <input name="title" class="form-control" value="{{ $b['title'] }}"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Gambar URL</label>
                                                            <input name="image_url" class="form-control"
                                                                value="{{ $b['image_url'] }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Link (opsional)</label>
                                                            <input name="link_url" class="form-control"
                                                                value="{{ $b['link_url'] ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-dark">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada banner.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================== PROMO ================== --}}
        <div class="tab-pane fade" id="promo-pane" role="tabpanel" aria-labelledby="promo-tab">
            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Tambah / Update Promo</div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.content.promo.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input name="title" class="form-control" placeholder="Judul promo" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Detail promo"></textarea>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col">
                                        <label class="form-label">Mulai</label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Selesai</label>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="active" id="promoActive">
                                    <label class="form-check-label" for="promoActive">Aktif</label>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-dark"><i class="bi bi-plus-lg me-1"></i> Simpan Promo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Daftar Promo</div>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0 table-fit">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($promos as $p)
                                        <tr>
                                            <td class="fw-semibold">{{ $p['title'] }}</td>
                                            <td>{{ $p['start_date'] }} s.d. {{ $p['end_date'] }}</td>
                                            <td>
                                                @if(!empty($p['active'])) <span class="badge bg-dark">Aktif</span>
                                                @else <span class="badge bg-secondary">Nonaktif</span> @endif
                                            </td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editPromo-{{ $p['id'] }}">Edit</button>
                                                <form class="d-inline" method="post"
                                                    action="{{ route('admin.content.promo.delete', $p['id']) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus promo ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Promo -->
                                        <div class="modal fade" id="editPromo-{{ $p['id'] }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post" action="{{ route('admin.content.promo.update', $p['id']) }}"
                                                    class="modal-content">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Promo</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Judul</label>
                                                            <input name="title" class="form-control" value="{{ $p['title'] }}"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Deskripsi</label>
                                                            <textarea name="description" class="form-control"
                                                                rows="3">{{ $p['description'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="row g-2 mb-3">
                                                            <div class="col">
                                                                <label class="form-label">Mulai</label>
                                                                <input type="date" name="start_date" class="form-control"
                                                                    value="{{ $p['start_date'] }}" required>
                                                            </div>
                                                            <div class="col">
                                                                <label class="form-label">Selesai</label>
                                                                <input type="date" name="end_date" class="form-control"
                                                                    value="{{ $p['end_date'] }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="active"
                                                                id="promoActive{{ $p['id'] }}" {{ !empty($p['active']) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="promoActive{{ $p['id'] }}">Aktif</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-dark">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada promo.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================== BLOG ================== --}}
        <div class="tab-pane fade" id="blog-pane" role="tabpanel" aria-labelledby="blog-tab">
            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Tambah / Update Blog</div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.content.blog.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input name="title" class="form-control" placeholder="Judul artikel" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cover URL (opsional)</label>
                                    <input name="cover_url" class="form-control" placeholder="https://...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ringkasan (opsional)</label>
                                    <textarea name="excerpt" class="form-control" rows="2"
                                        placeholder="Ringkas artikel"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konten</label>
                                    <textarea name="content" class="form-control" rows="6" required
                                        placeholder="Tulis konten di sini..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Publikasi (opsional)</label>
                                    <input type="date" name="published_at" class="form-control">
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-dark"><i class="bi bi-plus-lg me-1"></i> Simpan Blog</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Daftar Blog</div>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Publikasi</th>
                                        <th class="text-truncate">Ringkasan</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($blogs as $b)
                                        <tr>
                                            <td class="fw-semibold">
                                                <div>{{ $b['title'] }}</div>
                                                @if(!empty($b['cover_url']))
                                                    <small class="text-muted"><a href="{{ $b['cover_url'] }}" target="_blank">Lihat
                                                            cover</a></small>
                                                @endif
                                            </td>
                                            <td>{{ $b['published_at'] ?? '-' }}</td>
                                            <td class="text-truncate" style="max-width: 320px;">{{ $b['excerpt'] ?? '-' }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editBlog-{{ $b['id'] }}">Edit</button>
                                                <form class="d-inline" method="post"
                                                    action="{{ route('admin.content.blog.delete', $b['id']) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus posting ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Blog -->
                                        <div class="modal fade" id="editBlog-{{ $b['id'] }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <form method="post" action="{{ route('admin.content.blog.update', $b['id']) }}"
                                                    class="modal-content">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Blog</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Judul</label>
                                                            <input name="title" class="form-control" value="{{ $b['title'] }}"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Cover URL (opsional)</label>
                                                            <input name="cover_url" class="form-control"
                                                                value="{{ $b['cover_url'] ?? '' }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Ringkasan (opsional)</label>
                                                            <textarea name="excerpt" class="form-control"
                                                                rows="2">{{ $b['excerpt'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Konten</label>
                                                            <textarea name="content" class="form-control" rows="8"
                                                                required>{{ $b['content'] }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Publikasi (opsional)</label>
                                                            <input type="date" name="published_at" class="form-control"
                                                                value="{{ $b['published_at'] ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-dark">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada postingan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection