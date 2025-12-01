<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tjap Satu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f1f3f5; }
        /* Sidebar revamped: gradient, better contrast, sticky footer area */
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #1f2937 0%, #0f172a 100%); color: #e5e7eb; position: relative; }
        .sidebar a { color: #cbd5e1; text-decoration: none; display: block; padding: 12px 16px; border-radius: 8px; margin: 4px 12px; }
        .sidebar a:hover, .sidebar a.active { background-color: #0ea5e9; color: #fff; }
        .sidebar .brand { color: #fff; }
        /* Logout fixed at bottom */
        .sidebar-footer { position: absolute; bottom: 0; left: 0; right: 0; padding: 12px; border-top: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.1); }
        .logout-btn { width: 100%; display: flex; align-items: center; gap: 8px; justify-content: center; }
        /* Content area scroll improvements */
        .content-wrap { height: 100vh; overflow-y: auto; }
        /* Global button hover micro-interaction */
        .btn { transition: transform .06s ease, box-shadow .2s ease, background-color .2s ease, color .2s ease; }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        /* Ensure canvases resize correctly */
        canvas { max-width: 100%; height: auto !important; }
    </style>
    @stack('styles')
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0 sidebar collapse d-md-block" id="sidebarMenu">
            <div class="p-3 text-center border-bottom border-secondary brand">
                <h4 class="m-0">TJAP SATU</h4>
                <small>Admin Panel</small>
            </div>
            <div class="py-3">
                <a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.produk.index') }}" class="{{ Request::is('admin/produk*') ? 'active' : '' }}">
                    <i class="bi bi-cup-hot me-2"></i> Produk
                </a>
                <a href="{{ route('admin.pesanan.index') }}" class="{{ Request::is('admin/pesanan*') ? 'active' : '' }}">
                    <i class="bi bi-cart-check me-2"></i> Pesanan
                </a>


                <a href="{{ route('admin.customers.index') }}" class="{{ Request::is('admin/pelanggan*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Pelanggan
                </a>
                <a href="{{ route('admin.content.index') }}" class="{{ Request::is('admin/konten*') ? 'active' : '' }}">
                    <i class="bi bi-images me-2"></i> Kelola Konten
                </a>


                <a href="{{ route('admin.report.index') }}" class="{{ Request::is('admin/report*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line me-2"></i> Laporan
                </a>
                <a href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-2"></i> Lihat Website
                </a>
            </div>
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light logout-btn">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-10 ms-sm-auto px-md-4 py-4 content-wrap">
            <nav class="navbar navbar-light bg-light d-md-none mb-3">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-brand mb-0 h1">Tjap Satu Admin</span>
                </div>
            </nav>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
