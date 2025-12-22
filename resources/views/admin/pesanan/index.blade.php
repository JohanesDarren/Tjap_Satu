@extends('layouts.admin')

@section('content')
<h2 class="mb-4">Manajemen Pesanan</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 100px;">ID Order</th>
                        <th>Pelanggan</th>
                        <th style="width: 150px;">Tanggal</th>
                        <th style="width: 130px;">Total</th>
                        <th style="width: 100px;">Tipe</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $item)
                        <tr>
                            <td><strong>#{{ str_pad($item->id_order, 5, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>
                                <strong>{{ $item->customer->nama_lengkap ?? 'Guest' }}</strong>
                                <br>
                                <small class="text-muted">{{ $item->customer->no_telp ?? '-' }}</small>
                            </td>
                            <td>
                                <small>{{ $item->tanggal_order->format('d M Y H:i') }}</small>
                            </td>
                            <td><strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></td>
                            <td><span class="badge bg-secondary">{{ ucfirst($item->tipe_pesanan) }}</span></td>
                            <td>
                                <span class="badge bg-{{ $item->status_pesanan == 'selesai' ? 'success' : ($item->status_pesanan == 'proses' ? 'info' : 'warning') }}">
                                    {{ ucfirst($item->status_pesanan) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id_order }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="detailModal{{ $item->id_order }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Order #{{ str_pad($item->id_order, 5, '0', STR_PAD_LEFT) }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6 class="mb-3">Informasi Pelanggan</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <small class="text-muted">Nama</small>
                                                <p class="mb-0">{{ $item->customer->nama_lengkap }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">No. Telepon</small>
                                                <p class="mb-0">{{ $item->customer->no_telp }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <h6 class="mb-3">Item Pesanan</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th style="width: 70px;">Qty</th>
                                                        <th style="width: 130px;">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($item->detailOrders as $detail)
                                                        <tr>
                                                            <td>{{ $detail->product->nama_produk }}</td>
                                                            <td>{{ $detail->jumlah }}</td>
                                                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted">Subtotal</small>
                                                <p>Rp {{ number_format($item->subtotal_produk, 0, ',', '.') }}</p>
                                                <small class="text-muted">Biaya Layanan</small>
                                                <p>Rp {{ number_format($item->biaya_layanan, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Ongkir</small>
                                                <p>Rp {{ number_format($item->ongkir, 0, ',', '.') }}</p>
                                                <small class="text-muted">Total</small>
                                                <p><strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pesanan->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $pesanan->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
