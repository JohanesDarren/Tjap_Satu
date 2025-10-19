<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Kopi Tjap Satu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --tjap-green: #2E7D6D;
            --tjap-cream: #F3E9D2;
            --tjap-red: #C84B31;
            --tjap-dark-blue: #1B2A41;
        }
        body {
            background-color: var(--tjap-cream);
            font-family: 'Roboto', sans-serif;
            color: var(--tjap-dark-blue);
        }
        .header-title {
            font-family: 'Playfair Display', serif;
        }
        .nav-tabs {
            border-bottom: 2px solid var(--tjap-green);
        }
        .nav-tabs .nav-link {
            color: var(--tjap-green);
            border: none;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active,
        .nav-tabs .nav-link:hover {
            color: var(--tjap-red);
            background-color: transparent;
            border-bottom: 2px solid var(--tjap-red);
        }
        .product-card {
            border: 2px solid #ddd;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px A15px rgba(0,0,0,0.1);
            border-color: var(--tjap-green);
        }
        .card-title {
            font-family: 'Playfair Display', serif;
            color: var(--tjap-dark-blue);
        }
        .card-subtitle {
            font-size: 0.9rem;
        }
        .card-price {
            font-weight: bold;
            color: var(--tjap-green);
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
@include('components.header')
<div class="container my-5">
    <div class="text-center mb-5">
        <img src="{{ asset('images/logo-tjapsatu.png') }}" alt="Logo Tjap Satu" style="width: 100px; border-radius: 50%;" class="mb-3">
        <h1 class="header-title">DAFTAR HARGA</h1>
        <p>Biji Kopi Sangrai Pilihan Khas Tjap Satu</p>
    </div>

    <ul class="nav nav-tabs justify-content-center mb-4" id="categoryTabs">
        <li class="nav-item">
            <button class="nav-link active" data-jenis="semua">Semua</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-jenis="Arabika">Arabika</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-jenis="Robusta">Robusta</button>
        </li>
    </ul>

    <div class="row" id="product-list">
        @foreach($produk as $produk)
            <div class="col-lg-4 col-md-6 mb-4 product-item" data-jenis="{{ $produk['jenis'] }}">
                <a href="{{ route('produk.show', ['id' => $produk['id']]) }}" class="text-decoration-none">
                    <div class="card product-card h-100">
                        <img src="{{ asset($produk['gambar']) }}" class="card-img-top" alt="{{ $produk['nama'] }}" style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produk['nama'] }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $produk['proses'] }}</h6>
                            <p class="card-text mt-3">
                                <span class="card-price">
                                    Mulai dari Rp {{ number_format($produk['harga']['100gr'], 0, ',', '.') }}
                                </span>
                                <br>
                                <small>/100gr</small>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@include('components.footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kode JavaScript untuk filter tidak perlu diubah, akan bekerja dengan struktur baru.
        const tabButtons = document.querySelectorAll('#categoryTabs .nav-link');
        const productItems = document.querySelectorAll('.product-item');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const targetJenis = this.getAttribute('data-jenis');

                productItems.forEach(item => {
                    const itemJenis = item.getAttribute('data-jenis');
                    if (targetJenis === 'semua' || targetJenis === itemJenis) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
</body>
</html>