@extends('layouts.admin')

@section('title', 'Report &  Analytic')

@section('content')
<style>
    .stat-card { 
        background-color: #fff; 
        border: 1px solid #ddd; 
        border-radius: 8px; 
        padding: 1.5rem; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
    }
    .stat-card-title { 
        font-size: 1rem; 
        color: #6c757d; 
        margin-bottom: 0.5rem; 
    }
    .stat-card-value { 
        font-size: 2rem; 
        font-weight: bold; 
        color: var(--tjap-dark-blue); 
    }
    .stat-card-icon { 
        font-size: 2.5rem; 
        color: var(--tjap-green); 
        opacity: 0.5; 
    }
    .chart-container { 
        background-color: #fff; 
        padding: 1.25rem; 
        border-radius: 8px; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
        height: 100%; 
        min-height: 260px;
    }

    /* force canvas height so Chart.js will render */
    .chart-container canvas { 
        display: block; 
        width: 100% !important; 
        height: 320px !important; 
    }

    /* beri ruang bawah supaya tidak tertutup footer */
    .report-container { padding-bottom: 160px; }
</style>

<div class="container report-container">
    <h1 class="header-title mb-4">Report & Analytic</h1>

    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <small>Total Pendapatan</small>
                    <div class="fs-4 fw-bold">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <small>Total Pesanan</small>
                    <div class="fs-4 fw-bold">{{ $totalPesanan ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <small>Rata-rata per Pesanan</small>
                    <div class="fs-4 fw-bold">Rp {{ number_format($rataRataPesanan ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm bg-warning text-white">
                <div class="card-body">
                    <small>Pesanan Selesai</small>
                    <div class="fs-4 fw-bold">{{ $orderStatus['Selesai'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="chart-container">
                <h5 class="mb-3">Penjualan 7 Hari Terakhir</h5>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="chart-container mb-4">
                <h5 class="mb-3">Distribusi Status Pesanan</h5>
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-4">Produk Terlaris</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th style="width: 100px;">Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkFavorit as $nama => $jumlah)
                                    <tr>
                                        <td>{{ $nama }}</td>
                                        <td><span class="badge bg-primary">{{ $jumlah }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">Belum ada penjualan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-4">Penjualan Per Bulan ({{ now()->year }})</h5>
                    <canvas id="monthlyChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- load Chart.js here and initialize immediately inside the view to avoid depending on layout -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    // ensure data is valid JSON arrays/objects (controller untouched)
    const salesData   = @json($penjualanPerHari ?? []);
    const productData = @json($produkFavorit ?? []);
    console.log('salesData ->', salesData);
    console.log('productData ->', productData);

    // wait until DOM ready
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not loaded');
            return;
        }

        // line chart (sales)
        const salesEl = document.getElementById('salesChart');
        if (salesEl && salesData && Object.keys(salesData).length > 0) {
            const ctx = salesEl.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Object.keys(salesData),
                    datasets: [{
                        label: 'Pendapatan',
                        data: Object.values(salesData),
                        borderColor: '#2E7D6D',
                        backgroundColor: 'rgba(46, 125, 109, 0.12)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } }
                }
            });
        } else {
            console.info('salesChart not rendered - empty data or element missing');
        }

        // doughnut chart (status)
        const statusEl = document.getElementById('statusChart');
        if (statusEl && productData && Object.keys(productData).length > 0) {
            const ctx2 = statusEl.getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(productData),
                    datasets: [{
                        data: Object.values(productData),
                        backgroundColor: ['#2E7D6D','#C84B31','#1B2A41','#6b4f4f','#A8875F']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        } else {
            console.info('statusChart not rendered - empty data or element missing');
        }

        // bar chart (monthly revenue)
        const monthlyEl = document.getElementById('monthlyChart');
        if (monthlyEl && productData && Object.keys(productData).length > 0) {
            const ctx3 = monthlyEl.getContext('2d');
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: Object.keys(productData),
                    datasets: [{
                        label: 'Revenue (Rp)',
                        data: Object.values(productData),
                        backgroundColor: 'rgba(13, 110, 253, 0.8)',
                        borderColor: '#0d6efd',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } }
                }
            });
        } else {
            console.info('monthlyChart not rendered - empty data or element missing');
        }
    });
})();
</script>
@endsection