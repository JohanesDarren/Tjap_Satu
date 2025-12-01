<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk['nama'] ?? 'Detail Produk' }} - Tjap Satu</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* Styling Global agar konsisten */
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f9fafb; 
            color: #1f2937; 
            padding-bottom: 80px; /* Space untuk footer jika ada */
            margin-top: 70px;
        }

        .text-custom-green { color: #325B56; }
        .bg-custom-green { background-color: #325B56; color: white; }
        
        .btn-custom-green { 
            background-color: #325B56; 
            color: white; 
            border: none; 
            transition: all 0.3s;
        }
        .btn-custom-green:hover { 
            background-color: #264541; 
            color: white; 
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(50, 91, 86, 0.2);
        }

        /* Mobile Header */
        .mobile-header {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(4px);
            z-index: 1000;
            border-bottom: 1px solid #eee;
        }

        .product-detail-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 16px;
        }

        @media (max-width: 768px) {
            .product-detail-img {
                height: 300px;
            }
        }
    </style>
</head>
<body>

    <div class="fixed-top d-md-none mobile-header px-3 py-3 d-flex align-items-center shadow-sm">
        <a href="{{ route('produk.menu') }}" class="text-decoration-none text-dark d-flex align-items-center">
            <i class="bi bi-arrow-left fs-4 me-3"></i>
        </a>
        <span class="fw-bold fs-5 text-truncate">{{ $produk['nama'] }}</span>
    </div>

    <div class="container py-4 py-md-5 mt-5 mt-md-0" style="max-width: 1000px;">

        <div class="d-none d-md-block mb-4">
            <a href="{{ route('produk.menu') }}" class="text-decoration-none text-secondary d-inline-flex align-items-center hover-dark">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Menu
            </a>
        </div>

        <div class="row g-4 align-items-start">
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-2 bg-white">
                    @if(!empty($produk['gambar']))
                        <img src="{{ asset('uploads/' . $produk['gambar']) }}" 
                             class="product-detail-img" 
                             alt="{{ $produk['nama'] }}">
                    @else
                        <div class="product-detail-img bg-light d-flex align-items-center justify-content-center text-secondary rounded-4">
                            <div class="text-center">
                                <i class="bi bi-cup-hot fs-1 d-block mb-2"></i>
                                <span>Tidak ada gambar</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="ps-md-4">
                    <h1 class="fw-bold text-dark mb-2">{{ $produk['nama'] }}</h1>
                    
                    @if(($produk['jenis'] ?? '-') !== '-')
                        <span class="badge bg-secondary bg-opacity-10 text-secondary mb-3 px-3 py-2 rounded-pill">
                            {{ $produk['jenis'] }}
                        </span>
                    @endif

                    <h2 class="text-custom-green fw-bold mb-4">
                        Rp {{ number_format($produk['harga']['100gr'] ?? 0, 0, ',', '.') }}
                    </h2>

                    <hr class="border-secondary opacity-10 mb-4">

                    <h5 class="fw-bold fs-6 mb-2">Deskripsi Produk</h5>
                    <p class="text-secondary" style="line-height: 1.7;">
                        {{ $produk['deskripsi'] ?? 'Deskripsi belum tersedia.' }}
                    </p>
                    
                    @if(($produk['proses'] ?? '-') !== '-')
                    <p class="text-muted small mt-2">
                        <strong>Proses Pengolahan:</strong> {{ $produk['proses'] }}
                    </p>
                    @endif

                    <div class="bg-white border border-light-subtle rounded-3 p-3 mb-4 mt-4">
                        <div class="d-flex align-items-center gap-3 text-secondary small">
                            <div><i class="bi bi-shield-check me-1 text-success"></i> Kualitas Terjamin</div>
                            <div><i class="bi bi-clock-history me-1 text-warning"></i> Fresh Brewed</div>
                        </div>
                    </div>

                    <form action="{{ route('cart.add', $produk['id_product']) }}" method="POST">
                        @csrf
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-custom-green btn-lg fw-bold shadow-sm rounded-3">
                                <i class="bi bi-bag-plus me-2"></i> Tambahkan ke Keranjang
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>