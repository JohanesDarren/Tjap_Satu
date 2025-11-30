@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manajemen Pesanan</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Order</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan as $item)
                    <tr>
                        <td>#{{ $item->id_order }}</td>
                        <td>
                            {{ $item->customer->nama ?? 'Guest' }}<br>
                            <small class="text-muted">{{ $item->customer->no_telp ?? '-' }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_order)->format('d M Y H:i') }}</td>
                        <td class="fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $badge = match($item->status_pesanan) {
                                    'Selesai' => 'success',
                                    'Dikirim' => 'info',
                                    'Diproses' => 'primary',
                                    'Batal' => 'danger',
                                    default => 'warning'
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ $item->status_pesanan }}</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_order }}">
                                Detail & Status
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalDetail{{ $item->id_order }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Order #{{ $item->id_order }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <h6>Item Pesanan:</h6>
                                    <ul class="list-group mb-3">
                                        @foreach($item->detailOrders as $detail)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    {{ $detail->product->nama_produk ?? 'Produk Dihapus' }}
                                                    <small class="text-muted d-block">x{{ $detail->jumlah }}</small>
                                                </div>
                                                <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <form action="{{ route('admin.pesanan.updateStatus', $item->id_order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <label class="form-label fw-bold">Update Status:</label>
                                        <div class="input-group">
                                            <select name="status_pesanan" class="form-select">
                                                <option value="Pending" {{ $item->status_pesanan == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Diproses" {{ $item->status_pesanan == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="Dikirim" {{ $item->status_pesanan == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                <option value="Selesai" {{ $item->status_pesanan == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="Batal" {{ $item->status_pesanan == 'Batal' ? 'selected' : '' }}>Batal</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection