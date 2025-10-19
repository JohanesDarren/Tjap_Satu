@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
    <style>
        .metric-card .icon-wrap {
            width: 44px;
            height: 44px;
        }

        .metric-card .num {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .table-fit td,
        .table-fit th {
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Admin Dashboard</h1>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-dark">
            <i class="bi bi-box-seam me-2"></i>Kelola Produk
        </a>
    </div>

    {{-- === METRIC CARDS === --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card metric-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div
                        class="icon-wrap rounded-circle bg-dark text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-bag"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pesanan (Hari ini)</div>
                        <div class="num">{{ number_format($metrics['orders_today']) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card metric-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div
                        class="icon-wrap rounded-circle bg-dark text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pendapatan (Hari ini)</div>
                        <div class="num">Rp {{ number_format($metrics['revenue_today'], 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card metric-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div
                        class="icon-wrap rounded-circle bg-dark text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-week"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pendapatan (Minggu ini)</div>
                        <div class="num">Rp {{ number_format($metrics['revenue_this_week'], 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card metric-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div
                        class="icon-wrap rounded-circle bg-dark text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Rata2 Nilai Pesanan</div>
                        <div class="num">Rp {{ number_format($metrics['avg_order_value'], 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- === ROW: PENDAPATAN HARIAN & MINGGUAN === --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold"><i class="bi bi-activity me-2"></i>Pendapatan Harian</span>
                    <span class="text-muted small">7 hari terakhir</span>
                </div>
                <div class="card-body">
                    <canvas id="dailyRevenueChart" height="140"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold"><i class="bi bi-bar-chart-line me-2"></i>Pendapatan Mingguan</span>
                    <span class="text-muted small">8 minggu terakhir</span>
                </div>
                <div class="card-body">
                    <canvas id="weeklyRevenueChart" height="140"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- === ROW: RINGKASAN PESANAN & PRODUK TERLARIS === --}}
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header fw-semibold"><i class="bi bi-list-check me-2"></i>Ringkasan Status Pesanan</div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        @foreach($orderSummary as $status => $count)
                            <div class="col-6 col-md-3 mb-3">
                                <div class="p-3 border rounded">
                                    <div class="text-muted small">{{ $status }}</div>
                                    <div class="fs-5 fw-bold">{{ $count }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <canvas id="orderSummaryChart" height="140"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header fw-semibold"><i class="bi bi-trophy me-2"></i>Produk Terlaris</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-fit align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th class="text-end">Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $i => $p)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $p['name'] }}</td>
                                        <td class="text-end">{{ number_format($p['sold']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <canvas id="topProductsChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Chart.js CDN (kalau belum ada di layout admin) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Helper: format Rupiah tanpa simbol untuk tooltip
        function rupiah(x) { return new Intl.NumberFormat('id-ID').format(x); }

        // === DAILY REVENUE (Line) ===
        const dailyCtx = document.getElementById('dailyRevenueChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: @json($dailyRevenue['labels']),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($dailyRevenue['data']),
                    borderWidth: 2,
                    tension: .3,
                    fill: false
                }]
            },
            options: {
                plugins: {
                    tooltip: { callbacks: { label: ctx => 'Rp ' + rupiah(ctx.parsed.y) } },
                    legend: { display: false }
                },
                scales: {
                    y: { ticks: { callback: v => 'Rp ' + rupiah(v) } }
                }
            }
        });

        // === WEEKLY REVENUE (Bar) ===
        const weeklyCtx = document.getElementById('weeklyRevenueChart').getContext('2d');
        new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: @json($weeklyRevenue['labels']),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($weeklyRevenue['data']),
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    tooltip: { callbacks: { label: ctx => 'Rp ' + rupiah(ctx.parsed.y) } },
                    legend: { display: false }
                },
                scales: {
                    y: { ticks: { callback: v => 'Rp ' + rupiah(v) } }
                }
            }
        });

        // === ORDER SUMMARY (Doughnut) ===
        const orderSummaryCtx = document.getElementById('orderSummaryChart').getContext('2d');
        new Chart(orderSummaryCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($orderSummary)),
                datasets: [{
                    data: @json(array_values($orderSummary))
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '60%'
            }
        });

        // === TOP PRODUCTS (Horizontal Bar) ===
        const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
        new Chart(topProductsCtx, {
            type: 'bar',
            data: {
                labels: @json(collect($topProducts)->pluck('name')),
                datasets: [{
                    label: 'Terjual',
                    data: @json(collect($topProducts)->pluck('sold')),
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { ticks: { precision: 0 } } }
            }
        });
    </script>
@endpush