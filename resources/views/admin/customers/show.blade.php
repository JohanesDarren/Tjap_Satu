@extends('layouts.admin')
@section('title', 'Detail Pelanggan')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0">Detail Pelanggan</h1>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    {{-- Informasi Pelanggan --}}
                    <h5 class="mb-3">{{ data_get($customer, 'nama', '-') }}</h5>

                    <div class="small text-muted">Email</div>
                    <div class="mb-2">{{ data_get($customer, 'email', '-') }}</div>

                    <div class="small text-muted">Telepon</div>
                    <div class="mb-2">{{ data_get($customer, 'telepon', '-') }}</div>

                    <div class="small text-muted">Alamat</div>
                    <div>{{ data_get($customer, 'alamat', '-') }}</div>
                </div>
            </div>
        </div>

        {{-- Ringkasan Belanja --}}
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="small text-muted">Total Pesanan</div>
                            <div class="fs-4 fw-bold">
                                {{ number_format(data_get($summary, 'total_orders', 0)) }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="small text-muted">Total Belanja</div>
                            <div class="fs-5 fw-bold">
                                Rp {{ number_format(data_get($summary, 'total_spent', 0), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="small text-muted">Terakhir Belanja</div>
                            <div class="fw-semibold">
                                {{ data_get($summary, 'last_order_at', '-') }}
                            </div>
                        </div>
                    </div>
                    <hr>

                    {{-- Grafik Belanja --}}
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-semibold">Grafik Belanja per Bulan</span>
                        </div>
                        <canvas id="customerSpendChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Pembelian --}}
    <div class="card">
        <div class="card-header fw-semibold">Riwayat Pembelian</div>
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                        <tr>
                            <td>{{ data_get($o, 'id', '-') }}</td>
                            <td>{{ data_get($o, 'kode_pesanan', '-') }}</td>
                            <td>{{ data_get($o, 'created_at', '-') }}</td>
                            <td>
                                <span class="badge bg-dark">{{ data_get($o, 'status', 'N/A') }}</span>
                            </td>
                            <td class="text-end">
                                {{ number_format(data_get($o, 'total_order', 0), 0, ',', '.') }}
                            </td>
                        </tr>

                        {{-- Daftar item di dalam pesanan --}}
                        @if(!empty(data_get($o, 'items')))
                            <tr class="table-light">
                                <td></td>
                                <td colspan="4">
                                    <div class="small text-muted mb-2">Item</div>
                                    @foreach(data_get($o, 'items', []) as $item)
                                        <div>
                                            • {{ data_get($item, 'produk') }}
                                            — {{ data_get($item, 'jumlah') }}
                                            × Rp {{ number_format(data_get($item, 'harga', 0), 0, ',', '.') }}
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Chart.js untuk grafik pembelian --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('customerSpendChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Belanja (Rp)',
                    data: @json($chartData),
                    borderWidth: 1,
                    backgroundColor: 'rgba(255, 99, 132, 0.4)',
                    borderColor: 'rgba(255, 99, 132, 1)'
                }]
            },
            options: {
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y)
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush