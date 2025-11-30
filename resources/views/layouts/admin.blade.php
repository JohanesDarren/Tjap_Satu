<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tjap Satu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 15px; }
        .sidebar a:hover, .sidebar a.active { background-color: #495057; color: white; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0 sidebar collapse d-md-block" id="sidebarMenu">
            <div class="p-3 text-center border-bottom border-secondary">
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
        </div>

        <div class="col-md-10 ms-sm-auto px-md-4 py-4">
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
</body>
</html>