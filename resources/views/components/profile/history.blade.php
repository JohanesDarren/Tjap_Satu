<h3 class="h5 fw-bold mb-4 text-dark">Riwayat Pesanan</h3>

<div class="vstack gap-3">
    @forelse($orders as $order)
        <div class="card border border-light-subtle rounded-3 hover-shadow transition">
            <div class="card-body p-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex align-items-start gap-3">

                    <div class="d-none d-md-block">
                        @php
                            $p = optional($order->detailOrders->first())->product;
                            $g = $p->gambar ?? null;
                            $imgSrc = null;
                            if ($g) {
                                if (preg_match('/^https?:\/\//', $g)) {
                                    $imgSrc = $g;
                                } elseif (\Illuminate\Support\Str::startsWith($g, 'storage/')) {
                                    $imgSrc = asset($g);
                                } elseif (\Illuminate\Support\Str::startsWith($g, 'products/')) {
                                    $imgSrc = asset('storage/' . ltrim($g, '/'));
                                } elseif (\Illuminate\Support\Str::startsWith($g, 'uploads/')) {
                                    $imgSrc = asset($g);
                                } elseif (\Illuminate\Support\Str::startsWith($g, '/')) {
                                    $imgSrc = asset(ltrim($g, '/'));
                                } else {
                                    $imgSrc = asset('uploads/' . ltrim($g, '/'));
                                }
                            }
                        @endphp

                        @if($imgSrc)
                            <img src="{{ $imgSrc }}"
                                class="rounded border border-secondary-subtle"
                                style="width: 56px; height: 56px; object-fit: cover;" alt="Produk">
                        @else
                            <div class="rounded border border-secondary-subtle d-flex align-items-center justify-content-center"
                                 style="width: 56px; height: 56px; background:#f2f2f2;">
                                <i class="bi bi-cup-hot text-secondary"></i>
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h4 class="fw-bold fs-6 text-secondary mb-0">Order #{{ $order->id_order }}</h4>
                            @php
                                $status = strtolower($order->status_pesanan);
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