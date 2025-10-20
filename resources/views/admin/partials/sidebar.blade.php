<aside id="adminSidebar" class="bg-light border-end">
    <div class="p-3 border-bottom">
        <span class="text-muted text-uppercase small">Menu</span>
    </div>

    <nav class="list-group list-group-flush">
        {{-- Dashboard --}}
        <a href="{{ url('admin') }}" class="list-group-item list-group-item-action d-flex align-items-center
                {{ request()->is('admin') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        {{-- Manajemen Produk --}}
        <a href="{{ route('admin.produk.index') }}" class="list-group-item list-group-item-action d-flex align-items-center
                {{ request()->is('admin/produk*') ? 'active' : '' }}">
            <i class="bi bi-box-seam me-2"></i> Manajemen Produk
        </a>

        {{-- Manajemen Pesanan (buat rute /admin/pesanan sesuai kebutuhanmu) --}}
        <a href="{{ url('/admin/pesanan') }}" class="list-group-item list-group-item-action d-flex align-items-center
                {{ request()->is('admin/pesanan*') ? 'active' : '' }}">
            <i class="bi bi-receipt me-2"></i> Manajemen Pesanan
        </a>

        {{-- Manajemen Pelanggan --}}
        <a href="{{ url('/admin/pelanggan') }}" class="list-group-item list-group-item-action d-flex align-items-center
                {{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
            <i class="bi bi-people me-2"></i> Manajemen Pelanggan
        </a>

        {{-- Manajemen Konten --}}
        <a href="{{ route('admin.content.index') }}" class="list-group-item list-group-item-action d-flex align-items-center
          {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
            <i class="bi bi-card-text me-2"></i> Manajemen Konten
        </a>


        {{-- Laporan & Analitik --}}
        <a href="{{ url('/admin/report') }}" class="list-group-item list-group-item-action d-flex align-items-center
                {{ request()->is('admin/laporan*') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow me-2"></i> Laporan & Analitik
        </a>
    </nav>
</aside>

<style>
    #adminSidebar {
        width: 260px;
        min-height: 100vh;
        position: sticky;
        top: 0;
    }

    @media (max-width: 991.98px) {
        #adminSidebar {
            position: fixed;
            left: -280px;
            top: 56px;
            /* kira-kira setinggi header */
            height: calc(100vh - 56px);
            z-index: 1030;
            transition: left .25s ease;
        }

        #adminSidebar.show {
            left: 0;
        }
    }
</style>