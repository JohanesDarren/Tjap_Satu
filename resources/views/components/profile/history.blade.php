<h3 class="h5 fw-bold mb-4 text-dark">Riwayat Pesanan</h3>

<div class="vstack gap-3">
    @forelse($orders as $order)
        <div class="card border border-light-subtle rounded-3 hover-shadow transition">
            <div class="card-body p-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex align-items-start gap-3">

                    <div class="d-none d-md-block">
                        <img src="{{ asset('uploads/' . $order->detailOrders->first()->product->gambar) }}"
                            class="rounded border border-secondary-subtle"
                            style="width: 56px; height: 56px; object-fit: cover;" alt="Produk">
                    </div>

                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h4 class="fw-bold fs-6 text-secondary mb-0">Order #{{ $order->id_order }}</h4>
                            @php
                                // Ubah status jadi huruf kecil semua agar 'Selesai' terbaca sama dengan 'selesai'
                                $status = strtolower($order->status_pesanan);

                                // Cek kondisi
                                if ($status == 'selesai') {
                                    $badgeClass = 'bg-success text-white'; // Hijau Solid (Lebih Jelas)
                                } elseif ($status == 'dibatalkan') {
                                    $badgeClass = 'bg-danger text-white'; // Merah (Opsional)
                                } else {
                                    $badgeClass = 'bg-warning text-dark'; // Kuning (Pending/Proses)
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }} text-uppercase" style="font-size: 10px;">
                                {{ $order->status_pesanan }}
                            </span>
                        </div>
                        <p class="small text-muted mb-0">
                            {{ \Carbon\Carbon::parse($order->tanggal_order ?? now())->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-3 mt-md-0 text-md-end">
                    <p class="fw-bold text-dark mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    <a href="{{ route('profile.order.detail', $order->id_order) }}"
                        class="small text-primary text-decoration-none">Lihat Detail</a>
                </div>
            </div>
        </div>
    @empty
        <div class="card border border-dashed border-secondary-subtle rounded-3 p-5 text-center text-muted">
            Belum ada riwayat pesanan.
        </div>
    @endforelse
</div>