@extends('layouts.admin')
@section('title', 'Order Management')
@section('content')
<style>
    .kanban-board {
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        padding-bottom: 1rem;
    }
    .kanban-column {
        flex: 1;
        min-width: 300px;
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        padding: 1rem;
    }
    .kanban-column-title {
        font-family: 'Playfair Display', serif;
        border-bottom: 2px solid var(--tjap-green);
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    .order-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-left: 5px solid var(--tjap-green);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .order-card .order-id {
        font-weight: bold;
        color: var(--tjap-dark-blue);
    }
    .order-card .order-customer {
        font-weight: 500;
    }
    .order-card .order-total {
        font-weight: bold;
        color: var(--tjap-red);
    }
    .dropdown-toggle::after {
        display: none; 
    }
</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="header-title">Order Management</h1>
    </div>
    @php
        $kolom = [
            'Pesanan Baru' => collect($pesanan)->where('status', 'Pesanan Baru'),
            'Diproses' => collect($pesanan)->where('status', 'Diproses'),
            'Dikirim' => collect($pesanan)->where('status', 'Dikirim'),
            'Selesai' => collect($pesanan)->where('status', 'Selesai'),
        ];
        $statusOptions = ['Pesanan Baru', 'Diproses', 'Dikirim', 'Selesai'];
    @endphp

    <div class="kanban-board">
        @foreach($kolom as $status => $listPesanan)
            <div class="kanban-column">
                <h5 class="kanban-column-title">{{ $status }} <span class="badge bg-secondary rounded-pill">{{ count($listPesanan) }}</span></h5>
                
                @forelse($listPesanan as $pesanan)
                    <div class="order-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="order-id">{{ $pesanan['id'] }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($pesanan['tanggal_pesanan'])->format('d M Y') }}</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Ubah Status <i class="bi bi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($statusOptions as $option)
                                        <li><a class="dropdown-item status-change-btn" href="#" data-order-id="{{ $pesanan['id'] }}" data-new-status="{{ $option }}">{{ $option }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="order-customer">{{ $pesanan['nama_pelanggan'] }}</div>
                        <ul class="list-unstyled mt-2 mb-2">
                            @foreach($pesanan['items'] as $item)
                                <li><small>• {{ $item['nama_produk'] }} ({{ $item['ukuran'] }}) x{{ $item['jumlah'] }}</small></li>
                            @endforeach
                        </ul>
                        <div class="text-end order-total">
                            Rp {{ number_format($pesanan['total_harga'], 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center"><small>Tidak ada pesanan</small></p>
                @endforelse
            </div>
        @endforeach
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const statusChangeButtons = document.querySelectorAll('.status-change-btn');
        statusChangeButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const orderId = this.getAttribute('data-order-id');
                const newStatus = this.getAttribute('data-new-status');

                alert(`SIMULASI: Status untuk pesanan ${orderId} diubah menjadi "${newStatus}". Halaman akan kembali ke semula saat di-refresh.`);
    });
});
    });
</script>
@endsection