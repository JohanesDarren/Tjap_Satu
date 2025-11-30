@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h2>Detail Pelanggan</h2>
</div>

<div class="row g-4">
    {{-- Profil & Summary --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center py-4">
                <div class="display-1 text-secondary mb-3"><i class="bi bi-person-circle"></i></div>
                <h4>{{ $customer->nama }}</h4>
                <p class="text-muted">{{ $customer->email }}</p>
                <hr>
                <div class="text-start">
                    <p class="mb-1"><strong>No. Telp:</strong> {{ $customer->no_telp ?? '-' }}</p>
                    <p class="mb-1"><strong>Alamat:</strong> {{ $customer->alamat ?? '-' }}</p>
                    <p class="mb-1"><strong>Bergabung:</strong> {{ $customer->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted">Ringkasan Statistik</h6>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Total Transaksi</span>
                    <span class="fw-bold">{{ $summary['total_orders'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Total Pengeluaran</span>
                    <span class="fw-bold text-success">Rp {{ number_format($summary['total_spent'], 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Transaksi Terakhir</span>
                    <span>{{ $summary['last_order_at'] ? \Carbon\Carbon::parse($summary['last_order_at'])->diffForHumans() : '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart & Riwayat Order --}}
    <div class="col-md-8">
        {{-- Grafik --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5>Tren Belanja (6 Bulan Terakhir)</h5>
                <canvas id="customerChart" height="100"></canvas>
            </div>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Riwayat Pesanan</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID Order</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Item</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id_order }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_pesanan == 'Selesai' ? 'success' : ($order->status_pesanan == 'Diproses' ? 'warning' : 'secondary') }}">
                                    {{ $order->status_pesanan }}
                                </span>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                    @foreach($order->detailOrders as $detail)
                                        <li>{{ $detail->product->nama_produk ?? 'Produk Dihapus' }} ({{ $detail->jumlah }}x)</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Belum ada riwayat pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('customerChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Pengeluaran (Rp)',
                    data: @json($chartData),
                    borderColor: '#2E7D6D',
                    backgroundColor: 'rgba(46, 125, 109, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
@endsection