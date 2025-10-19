@extends('layouts.app')
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
        padding: 1.5rem; 
        border-radius: 8px; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
        height: 100%; 
        }
</style>
<div class="container-fluid mb-5">
    <h1 class="header-title mb-4">Report & Analytic</h1>

    <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="stat-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-card-title">Total Pendapatan</div>
                    <div class="stat-card-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-cash-stack stat-card-icon"></i>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="stat-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-card-title">Total Pesanan</div>
                    <div class="stat-card-value">{{ $totalPesanan }}</div>
                </div>
                <i class="bi bi-cart-check stat-card-icon"></i>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="stat-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-card-title">Rata-rata per Pesanan</div>
                    <div class="stat-card-value">Rp {{ number_format($rataRataPesanan, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-graph-up stat-card-icon"></i>
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
                <h5 class="mb-3">Komposisi Produk Terlaris</h5>
                <canvas id="productPieChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const salesData = @json($penjualanPerHari ?? []);
        const productData = @json($produkFavorit ?? []);

        if (Object.keys(salesData).length > 0) {
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, { type: 'line', data: { labels: Object.keys(salesData), datasets: [{ label: 'Pendapatan', data: Object.values(salesData), borderColor: '#2E7D6D', backgroundColor: 'rgba(46, 125, 109, 0.1)', fill: true, tension: 0.3 }] } });
        }

        if (Object.keys(productData).length > 0) {
            const pieCtx = document.getElementById('productPieChart').getContext('2d');
            new Chart(pieCtx, { type: 'pie', data: { labels: Object.keys(productData), datasets: [{ label: 'Jumlah Terjual', data: Object.values(productData), backgroundColor: ['#2E7D6D', '#C84B31', '#1B2A41', '#6b4f4f', '#A8875F'], hoverOffset: 4 }] } });
        }
    });
    </script>
@endsection