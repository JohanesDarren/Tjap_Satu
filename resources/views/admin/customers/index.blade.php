@extends('layouts.admin')

@section('title', 'Pelanggan')

@push('styles')
<style>
    .table-fit td, .table-fit th { white-space: nowrap; }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0">Daftar Pelanggan</h1>
    <a href="{{ url('/admin') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Dashboard
    </a>
</div>

<form class="row g-2 mb-3" method="get" action="#">
    <div class="col-md-4">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari nama / email / telepon">
    </div>
    <div class="col-md-3">
        <input type="date" name="from" value="{{ $from }}" class="form-control">
    </div>
    <div class="col-md-3">
        <input type="date" name="to" value="{{ $to }}" class="form-control">
    </div>
    <div class="col-md-2 d-grid">
        <button class="btn btn-dark"><i class="bi bi-search me-1"></i> Filter</button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover table-sm align-middle table-fit mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th class="text-end">Jumlah Pesanan</th>
                    <th class="text-end">Total Belanja</th>
                    <th>Terakhir Belanja</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                    <tr>
                        <td class="fw-semibold">{{ $c['nama'] }}</td>
                        <td>{{ $c['email'] }}</td>
                        <td>{{ $c['telepon'] }}</td>
                        <td class="text-end">{{ number_format($c['orders_count']) }}</td>
                        <td class="text-end">Rp {{ number_format($c['total_spent'], 0, ',', '.') }}</td>
                        <td>
                            {{ $c['last_order_at'] 
                                ? \Carbon\Carbon::parse($c['last_order_at'])->format('d M Y H:i')
                                : '-' }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.customers.show', $c['id']) }}" 
                               class="btn btn-sm btn-dark">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Belum ada data pelanggan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection