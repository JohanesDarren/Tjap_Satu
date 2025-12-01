<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->id_order }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }

        .text-custom-green {
            color: #325B56;

        }

        .bg-custom-green {
            background-color: #325B56;
            color: white;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .mobile-header {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>

    <div class="fixed-top d-md-none mobile-header px-3 py-3 d-flex align-items-center">
        <a href="{{ route('profile.index') }}" class="text-decoration-none text-dark d-flex align-items-center">
            <i class="bi bi-arrow-left fs-4 me-3"></i>
        </a>
        <span class="fw-bold fs-5">Detail Pesanan</span>
    </div>

    <div class="container py-4 py-md-5 mt-5 mt-md-0" style="max-width: 800px;">

        <div class="d-none d-md-block mb-4">
            <a href="{{ route('profile.index') }}"
                class="text-decoration-none text-secondary d-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Profil
            </a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Order #{{ $order->id_order }}</h1>
                <p class="text-muted small mb-0">
                    {{ \Carbon\Carbon::parse($order->tanggal_order ?? now())->setTimezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB
                </p>
            </div>
            @php

                $status = strtolower($order->status_pesanan);

                // Cek kondisi
                if ($status == 'selesai') {
                    $badgeClass = 'bg-success text-white';
                } elseif ($status == 'dibatalkan') {
                    $badgeClass = 'bg-danger text-white';
                } else {
                    $badgeClass = 'bg-warning text-dark';
                }
            @endphp
            <span
                class="badge {{ $badgeClass }} px-3 py-2 rounded-pill text-uppercase">{{ $order->status_pesanan }}</span>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0 fs-6">Rincian Produk</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 small text-muted text-uppercase fw-bold">Produk</th>
                                <th class="py-3 small text-muted text-uppercase fw-bold text-center">Qty</th>
                                <th class="pe-4 py-3 small text-muted text-uppercase fw-bold text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->detailOrders as $detail)
                                @php
                                    $g = $detail->product->gambar ?? null;
                                    if ($g) {
                                        if (preg_match('/^https?:\/\//', $g)) {
                                            $imgSrc = $g;
                                        } elseif (\Illuminate\Support\Str::startsWith($g, ['uploads/', '/'])) {
                                            $imgSrc = asset($g);
                                        } else {
                                            $imgSrc = asset('uploads/' . ltrim($g, '/'));
                                        }
                                    } else {
                                        $imgSrc = null;
                                    }
                                @endphp
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            @if($imgSrc)
                                                <img src="{{ $imgSrc }}" class="product-img me-3 border" alt="Produk">
                                            @else
                                                <div class="product-img me-3 bg-light d-flex align-items-center justify-content-center text-secondary">
                                                    <i class="bi bi-cup-hot"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark">{{ $detail->product->nama_produk }}</h6>
                                                <small class="text-muted">Rp {{ number_format($detail->product->harga, 0, ',', '.') }} / item</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-medium">{{ $detail->jumlah }}x</td>
                                    <td class="pe-4 text-end fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 fs-6">Ringkasan Pembayaran</h5>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Metode Pembayaran</span>
                    <span class="fw-medium text-uppercase">{{ $order->payment->metode_bayar ?? 'Transfer' }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Belanja</span>
                    <span class="fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>

                <hr class="border-secondary opacity-10 my-3">

                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5 text-custom-green">Total Bayar</span>
                    <span class="fw-bold fs-4 text-custom-green">Rp
                        {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="#" class="text-decoration-none text-muted small">
                <i class="bi bi-question-circle me-1"></i> Butuh bantuan dengan pesanan ini?
            </a>
        </div>

    </div>

</body>

</html>
