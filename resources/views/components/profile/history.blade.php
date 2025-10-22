{{-- ========================== PESANAN ========================== --}}
<div id="pesanan" class="tab-section" style="display:none;">
    <div class="container my-5">
        <h3 class="fw-bold mb-4 text-dark"><i></i> Riwayat Pesanan</h3>
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <!-- Search -->
            <input type="text" class="form-control" placeholder="Cari transaksimu di sini" style="max-width: 250px;">

            <!-- Dropdown Produk -->
            <select class="form-select" style="max-width: 200px;">
                <option selected>Semua Produk</option>
                <option>Selesai</option>
                <option>Dikirim</option>
                <option>Diproses</option>
            </select>

            <!-- Date Picker -->
            <input type="date" class="form-control" style="max-width: 200px;">
        </div>


        @if (!empty($orders) && count($orders) > 0)
            <div class="order-list">
                @foreach ($orders as $order)
                    <div class="order-card">
                        <img src="{{ $order['gambar'] }}" class="order-img" alt="{{ $order['produk'] }}">
                        <div class="order-info">
                            <h5>{{ $order['produk'] }}</h5>
                            <div class="order-meta"><i class="bi bi-calendar3"></i> {{ $order['tanggal'] }}
                            </div>
                            <div class="order-meta"><i class="bi bi-upc"></i> {{ $order['id'] }}</div>
                            <p class="fw-semibold mb-2 mt-2">Total: <span
                                    class="text-danger">{{ $order['total'] }}</span></p>
                            <span
                                class="order-status 
                                @if ($order['status'] == 'Selesai') selesai
                                @elseif($order['status'] == 'Dikirim') dikirim
                                @elseif($order['status'] == 'Diproses') diproses
                                @else batal @endif
                            ">{{ $order['status'] }}</span>
                        </div>
                        {{-- <div class="text-end ms-auto">
                            <button class="btn btn-detail btn-sm"><i class="bi bi-eye"></i> Detail</button>
                        </div> --}}
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Belum ada pesanan.</p>
        @endif
    </div>
</div>
