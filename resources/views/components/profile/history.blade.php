<h3 class="h5 fw-bold mb-4 text-dark">Riwayat Pesanan</h3>
                        
                        <div class="vstack gap-3">
                            @forelse($orders as $order)
                            <div class="card border border-light-subtle rounded-3 hover-shadow transition">
                                <div class="card-body p-3 d-flex flex-column flex-md-row justify-content-between">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="bg-light p-2 rounded d-none d-md-block text-secondary">
                                            <i class="bi bi-bag fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <h4 class="fw-bold fs-6 text-secondary mb-0">Order #{{ $order->id_order }}</h4>
                                                @php
                                                    $badgeClass = $order->status_pesanan == 'selesai' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';
                                                @endphp
                                                <span class="badge {{ $badgeClass }} text-uppercase" style="font-size: 10px;">
                                                    {{ $order->status_pesanan }}
                                                </span>
                                            </div>
                                            <p class="small text-muted mb-0">{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 mt-md-0 text-md-end">
                                        <p class="fw-bold text-dark mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                        <a href="#" class="small text-primary text-decoration-none">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="card border border-dashed border-secondary-subtle rounded-3 p-5 text-center text-muted">
                                Belum ada riwayat pesanan.
                            </div>
                            @endforelse
                        </div>