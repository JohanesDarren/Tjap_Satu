@extends('layouts.admin')
@section('title', 'Manajemen Konten')

@push('styles')
<style>
    .thumb-banner { width: 180px; height: 56px; object-fit: cover; border-radius: .5rem; }
    .table-fit td, .table-fit th { white-space: nowrap; }
    .modal-backdrop.show { opacity: .6 !important; }
    .modal-dialog { margin-top: 8vh; }
    .table-hover>tbody>tr:hover { background: #f8fafc; }
    .nav-pills .nav-link { border-radius: 50px; padding: .55rem 1rem; font-weight: 500; transition:.25s; }
    .nav-pills .nav-link.active { background: linear-gradient(90deg,#0ea5e9,#2563eb); box-shadow:0 4px 12px rgba(14,165,233,.35); }
    .nav-pills .nav-link:not(.active):hover { background:#e2e8f0; color:#0f172a; }
    .card { border:1px solid #e5e7eb; box-shadow:0 2px 6px rgba(0,0,0,.05); transition:.25s; }
    .card:hover { box-shadow:0 6px 22px rgba(0,0,0,.08); }
    .card-header { background: #f1f5f9; }
    .btn { transition: background-color .25s, color .25s, box-shadow .25s, transform .12s; }
    .btn:active { transform:scale(.96); }
    .btn-outline-secondary:hover { background:#64748b; color:#fff; }
    .btn-dark { background: linear-gradient(90deg,#334155,#1e293b); border:0; }
    .btn-dark:hover { background: linear-gradient(90deg,#475569,#334155); box-shadow:0 4px 14px rgba(0,0,0,.2); }
    .btn-outline-danger:hover { background:#dc2626; border-color:#dc2626; color:#fff; }
    .btn-outline-secondary, .btn-outline-danger, .btn-outline-success { backdrop-filter: blur(2px); }
    .btn-soft-primary { background:#e0f2fe; color:#0369a1; border:1px solid #7dd3fc; }
    .btn-soft-primary:hover { background:#bae6fd; color:#0c4a6e; }
    .badge.bg-success { background: linear-gradient(90deg,#16a34a,#15803d); }
    .badge.bg-secondary { background: linear-gradient(90deg,#475569,#334155); }
    .modal-content { border:1px solid #e2e8f0; box-shadow:0 10px 30px rgba(0,0,0,.25); }
    .modal-header { background:#f8fafc; }
    .form-control { border-color:#cbd5e1; }
    .form-control:focus { border-color:#2563eb; box-shadow:0 0 0 .2rem rgba(37,99,235,.25); }
    .form-check-input:checked { background-color:#2563eb; border-color:#2563eb; }
    .text-truncate a { text-decoration:none; }
    .text-truncate a:hover { text-decoration:underline; }
</style>
@endpush

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1">Manajemen Konten</h1>
            <div class="text-muted small">Kelola banner, promo, dan blog.</div>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <div class="fw-semibold mb-1">Validasi gagal</div>
            <ul class="mb-0 small">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-pills mb-3" id="cmsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="banner-tab" data-bs-toggle="pill" data-bs-target="#banner-pane" type="button" role="tab">
                <i class="bi bi-image me-1"></i> Banner
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="promo-tab" data-bs-toggle="pill" data-bs-target="#promo-pane" type="button" role="tab">
                <i class="bi bi-megaphone me-1"></i> Promo
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="blog-tab" data-bs-toggle="pill" data-bs-target="#blog-pane" type="button" role="tab">
                <i class="bi bi-journal-text me-1"></i> Blog
            </button>
        </li>
    </ul>

    <div class="tab-content">
        {{-- ===================== TAB BANNER (TIDAK BERUBAH) ===================== --}}
        <div class="tab-pane fade show active" id="banner-pane" role="tabpanel" aria-labelledby="banner-tab">
            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center gap-2">
                            <i class="bi bi-plus-square"></i>
                            <span class="fw-semibold">Tambah Banner</span>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.content.banner.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input name="title" class="form-control" placeholder="Judul banner" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp" required>
                                    <div class="form-text">Format: jpg, jpeg, png, webp. Maks 2MB.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Link (opsional)</label>
                                    <input name="link_url" class="form-control" placeholder="https://...">
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-dark"><i class="bi bi-save me-1"></i> Simpan Banner</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Daftar Banner</div>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm align-middle mb-0 table-fit">
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
                                            <td>@if($b->image_path)<img class="thumb-banner" src="{{ asset('storage/'.$b->image_path) }}" alt="">@endif</td>
                                            <td class="fw-semibold">{{ $b->title }}</td>
                                            <td class="text-truncate" style="max-width: 240px;">@if($b->link_url)<a href="{{ $b->link_url }}" target="_blank">{{ $b->link_url }}</a>@else - @endif</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editBanner-{{ $b->id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form class="d-inline" method="post" action="{{ route('admin.content.banner.delete', $b->id) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus banner ini?')"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @push('modals')
                                            <div class="modal fade" id="editBanner-{{ $b->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post" action="{{ route('admin.content.banner.update', $b->id) }}" class="modal-content" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Banner</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Judul</label>
                                                                <input name="title" class="form-control" value="{{ $b->title }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Gambar</label>
                                                                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                                                                @if($b->image_path)
                                                                    <small class="text-muted d-block mt-1">Gambar saat ini:</small>
                                                                    <img class="thumb-banner mt-1" src="{{ asset('storage/'.$b->image_path) }}" alt="">
                                                                @endif
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Link (opsional)</label>
                                                                <input name="link_url" class="form-control" value="{{ $b->link_url }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button class="btn btn-dark">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endpush
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

        {{-- ===================== TAB PROMO (DIUPDATE) ===================== --}}
        <div class="tab-pane fade" id="promo-pane" role="tabpanel" aria-labelledby="promo-tab">
            <div class="row g-3">
                {{-- Form Tambah Promo --}}
                <div class="col-lg-5">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center gap-2">
                            <i class="bi bi-plus-square"></i>
                            <span class="fw-semibold">Tambah Promo</span>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.content.promo.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Judul Promo</label>
                                    <input name="title" class="form-control" placeholder="Contoh: Diskon Kemerdekaan" required>
                                </div>

                                {{-- Added: Kode Voucher --}}
                                <div class="mb-3">
                                    <label class="form-label">Kode Voucher</label>
                                    <input name="code" class="form-control text-uppercase" placeholder="Contoh: MERDEKA45" required>
                                    <div class="form-text">Harus unik, huruf & angka tanpa spasi.</div>
                                </div>

                                {{-- Added: Tipe & Nilai Diskon --}}
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Tipe Diskon</label>
                                        <select name="discount_type" class="form-select" required>
                                            <option value="percentage">Persentase (%)</option>
                                            <option value="fixed">Nominal (Rp)</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Nilai Diskon</label>
                                        <input type="number" name="discount_value" class="form-control" placeholder="10 atau 15000" required>
                                    </div>
                                </div>

                                {{-- Added: Syarat & Ketentuan Diskon --}}
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Min. Belanja</label>
                                        <input type="number" name="min_purchase" class="form-control" placeholder="0" value="0">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Maks. Diskon</label>
                                        <input type="number" name="max_discount" class="form-control" placeholder="Opsional">
                                        <div class="form-text" style="font-size: 10px; line-height: 1.2;">Kosongkan jika tidak ada batas</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="2" placeholder="Detail promo"></textarea>
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
                                    <input class="form-check-input" type="checkbox" name="active" id="promoActive" checked>
                                    <label class="form-check-label" for="promoActive">Aktifkan Segera</label>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-dark"><i class="bi bi-save me-1"></i> Simpan Promo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Tabel Daftar Promo --}}
                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Daftar Promo</div>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm align-middle mb-0 table-fit">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode / Judul</th>
                                        <th>Diskon</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($promos as $p)
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-primary">{{ $p->code }}</div>
                                                <div class="small text-muted text-truncate" style="max-width: 150px;">{{ $p->title }}</div>
                                            </td>
                                            <td>
                                                @if($p->discount_type == 'percentage')
                                                    <span class="badge bg-info text-dark">{{ (int)$p->discount_value }}%</span>
                                                    @if($p->max_discount)
                                                        <div style="font-size: 10px;">Max: {{ number_format($p->max_discount,0,',','.') }}</div>
                                                    @endif
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ number_format($p->discount_value,0,',','.') }}</span>
                                                @endif

                                                @if($p->min_purchase > 0)
                                                    <div class="text-muted" style="font-size: 10px;">Min: {{ number_format($p->min_purchase,0,',','.') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div style="font-size: 12px;">
                                                    {{ \Carbon\Carbon::parse($p->start_date)->format('d/m/y') }} <br>
                                                    s.d. {{ \Carbon\Carbon::parse($p->end_date)->format('d/m/y') }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($p->active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editPromo-{{ $p->id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form class="d-inline" method="post" action="{{ route('admin.content.promo.delete', $p->id) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus promo ini?')"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>

                                        {{-- MODAL EDIT PROMO (DIUPDATE) --}}
                                        @push('modals')
                                            <div class="modal fade" id="editPromo-{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post" action="{{ route('admin.content.promo.update', $p->id) }}" class="modal-content">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Promo: {{ $p->code }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Judul Promo</label>
                                                                <input name="title" class="form-control" value="{{ $p->title }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Voucher</label>
                                                                <input name="code" class="form-control text-uppercase" value="{{ $p->code }}" required>
                                                            </div>

                                                            <div class="row g-2 mb-3">
                                                                <div class="col-6">
                                                                    <label class="form-label">Tipe Diskon</label>
                                                                    <select name="discount_type" class="form-select" required>
                                                                        <option value="percentage" {{ $p->discount_type == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                                                        <option value="fixed" {{ $p->discount_type == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Nilai Diskon</label>
                                                                    <input type="number" name="discount_value" class="form-control" value="{{ (int)$p->discount_value }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="row g-2 mb-3">
                                                                <div class="col-6">
                                                                    <label class="form-label">Min. Belanja</label>
                                                                    <input type="number" name="min_purchase" class="form-control" value="{{ (int)$p->min_purchase }}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Maks. Diskon</label>
                                                                    <input type="number" name="max_discount" class="form-control" value="{{ $p->max_discount ? (int)$p->max_discount : '' }}" placeholder="Unlimited">
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Deskripsi</label>
                                                                <textarea name="description" class="form-control" rows="3">{{ $p->description }}</textarea>
                                                            </div>
                                                            <div class="row g-2 mb-3">
                                                                <div class="col">
                                                                    <label class="form-label">Mulai</label>
                                                                    <input type="date" name="start_date" class="form-control" value="{{ \Carbon\Carbon::parse($p->start_date)->format('Y-m-d') }}" required>
                                                                </div>
                                                                <div class="col">
                                                                    <label class="form-label">Selesai</label>
                                                                    <input type="date" name="end_date" class="form-control" value="{{ \Carbon\Carbon::parse($p->end_date)->format('Y-m-d') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="active" id="promoActive{{ $p->id }}" {{ $p->active ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="promoActive{{ $p->id }}">Aktif</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button class="btn btn-dark">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endpush
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada promo.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== TAB BLOG (TIDAK BERUBAH) ===================== --}}
        <div class="tab-pane fade" id="blog-pane" role="tabpanel" aria-labelledby="blog-tab">
            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center gap-2">
                            <i class="bi bi-plus-square"></i>
                            <span class="fw-semibold">Tambah Blog</span>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.content.blog.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input name="title" class="form-control" placeholder="Judul artikel" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cover (opsional)</label>
                                    <input type="file" name="cover" class="form-control" accept="image/jpeg,image/png,image/webp">
                                    <div class="form-text">Maks 2MB.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ringkasan (opsional)</label>
                                    <textarea name="excerpt" class="form-control" rows="2" placeholder="Ringkas artikel"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konten</label>
                                    <textarea name="content" class="form-control" rows="6" required placeholder="Tulis konten di sini..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Publikasi (opsional)</label>
                                    <input type="date" name="published_at" class="form-control">
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-dark"><i class="bi bi-save me-1"></i> Simpan Blog</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-header fw-semibold">Daftar Blog</div>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm align-middle mb-0">
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
                                                <div>{{ $b->title }}</div>
                                                @if($b->cover_path)
                                                    <small class="text-muted d-block mt-1"><a href="{{ asset('storage/'.$b->cover_path) }}" target="_blank">Lihat cover</a></small>
                                                @endif
                                            </td>
                                            <td>{{ $b->published_at ? $b->published_at->toDateString() : '-' }}</td>
                                            <td class="text-truncate" style="max-width: 320px;">{{ $b->excerpt ?? '-' }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editBlog-{{ $b->id }}"><i class="bi bi-pencil"></i></button>
                                                <form class="d-inline" method="post" action="{{ route('admin.content.blog.delete', $b->id) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus posting ini?')"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @push('modals')
                                            <div class="modal fade" id="editBlog-{{ $b->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <form method="post" action="{{ route('admin.content.blog.update', $b->id) }}" class="modal-content" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Blog</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Judul</label>
                                                                <input name="title" class="form-control" value="{{ $b->title }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Cover (opsional)</label>
                                                                <input type="file" name="cover" class="form-control" accept="image/jpeg,image/png,image/webp">
                                                                @if($b->cover_path)
                                                                    <small class="text-muted d-block mt-1">Cover saat ini:</small>
                                                                    <img class="thumb-banner mt-1" src="{{ asset('storage/'.$b->cover_path) }}" alt="">
                                                                @endif
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Ringkasan (opsional)</label>
                                                                <textarea name="excerpt" class="form-control" rows="2">{{ $b->excerpt ?? '' }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Konten</label>
                                                                <textarea name="content" class="form-control" rows="8" required>{{ $b->content }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal Publikasi (opsional)</label>
                                                                <input type="date" name="published_at" class="form-control" value="{{ $b->published_at ? $b->published_at->toDateString() : '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button class="btn btn-dark">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endpush
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

@stack('modals')
