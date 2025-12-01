@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Pelanggan</h2>
</div>

{{-- Filter & Search --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" placeholder="Cari nama, email, atau no telp..." value="{{ $q }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="from" class="form-control" value="{{ $from }}" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-3">
                <input type="date" name="to" class="form-control" value="{{ $to }}" placeholder="Sampai Tanggal">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama Pelanggan</th>
                        <th>Kontak</th>
                        <th>Total Order</th>
                        <th>Total Belanja</th>
                        <th>Order Terakhir</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $cust)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">{{ $cust->nama_lengkap }}</div>
                            <small class="text-muted">ID: {{ $cust->id_cust }}</small>
                        </td>
                        <td>
                            <div>{{ $cust->email }}</div>
                            <small class="text-muted">{{ $cust->no_telp ?? '-' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $cust->orders_count }} Transaksi</span>
                        </td>
                        <td class="fw-bold text-success">
                            Rp {{ number_format($cust->total_spent, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($cust->last_order_at)
                                {{ \Carbon\Carbon::parse($cust->last_order_at)->format('d M Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.customers.show', $cust->id_cust) }}" class="btn btn-sm btn-info text-white me-1" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('admin.customers.destroy', $cust->id_cust) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pelanggan ini?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Tidak ada data pelanggan yang sesuai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
