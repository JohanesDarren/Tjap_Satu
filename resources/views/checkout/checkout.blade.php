<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Kopi Tjap Satu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
</head>

<body>

    <div class="fixed-top d-md-none bg-white shadow-sm px-3 py-3 d-flex align-items-center">
        <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark d-flex align-items-center">
            <i class="bi bi-arrow-left fs-5 me-3"></i>
        </a>
        <span class="fw-bold fs-5">Checkout</span>
    </div>

    <div class="container py-4 py-md-5 mt-5 mt-md-0" style="max-width: 1100px;">

        <div class="d-none d-md-block mb-4">
            <a href="{{ route('cart.index') }}"
                class="text-decoration-none text-secondary d-inline-flex align-items-center hover-dark">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Keranjang
            </a>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" id="paymentForm">
            @csrf

            @foreach($checkoutItems as $item)
                <input type="hidden" name="items[]" value="{{ $item->id_item }}">
            @endforeach

            <div class="row g-4">

                <div class="col-lg-7">

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold fs-6 mb-3"><i class="bi bi-truck me-2 text-custom-green"></i>Metode
                                Pengiriman</h5>

                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="shipping-card w-100" onclick="updateShipping('delivery')">
                                        <input type="radio" name="shipping_type" value="delivery" class="d-none"
                                            checked>
                                        <i class="bi bi-check-circle-fill check-icon"></i>
                                        <i class="bi bi-bicycle fs-3 mb-2 text-secondary"></i>
                                        <span class="small fw-bold">Dikirim Kurir</span>
                                        <span class="text-muted" style="font-size: 10px;">Ongkir Rp 10.000</span>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="shipping-card w-100" onclick="updateShipping('pickup')">
                                        <input type="radio" name="shipping_type" value="pickup" class="d-none">
                                        <i class="bi bi-check-circle-fill check-icon"></i>
                                        <i class="bi bi-shop fs-3 mb-2 text-secondary"></i>
                                        <span class="small fw-bold">Ambil di Toko</span>
                                        <span class="text-muted" style="font-size: 10px;">Bebas Ongkir</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-3 bg-light p-3 rounded-3 border border-secondary-subtle">
                                <div id="address-delivery">
                                    <p class="small text-muted mb-1 text-uppercase fw-bold">Alamat Pengiriman</p>
                                    <p class="fw-bold mb-1">{{ $customer->nama_lengkap }} <span
                                            class="fw-normal text-muted">| {{ $customer->no_telp }}</span></p>
                                    <p class="small text-secondary mb-0">
                                        {{ $customer->alamat ?? 'Harap isi alamat di profil.' }}</p>
                                </div>
                                <div id="address-pickup" class="d-none">
                                    <p class="small text-muted mb-1 text-uppercase fw-bold">Lokasi Pengambilan</p>
                                    <p class="fw-bold mb-1">Toko Kopi Tjap Satu</p>
                                    <p class="small text-secondary mb-0">Jl. Raya Soreang - Kopo No.430, Cingcin, Kec.
                                        Soreang, Kabupaten Bandung, Jawa Barat 40922</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold fs-6 mb-3"><i class="bi bi-bag-check me-2 text-custom-green"></i>Rincian
                                Pesanan</h5>

                            <div class="vstack gap-3 mb-4">
                                @foreach($checkoutItems as $item)
                                    @php
                                        $g = $item->product->gambar ?? null;
                                        $imgSrc = null;
                                        if ($g) {
                                            if (preg_match('/^https?:\/\//', $g)) {
                                                $imgSrc = $g;
                                            } elseif (\Illuminate\Support\Str::startsWith($g, 'storage/')) {
                                                $imgSrc = asset($g);
                                            } elseif (\Illuminate\Support\Str::startsWith($g, 'products/')) {
                                                // old storage path stored as products/.. on public disk
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
                                    <div class="d-flex align-items-center gap-3">
                                        @if($imgSrc)
                                            <img src="{{ $imgSrc }}" class="checkout-img border" alt="Produk">
                                        @else
                                            <div class="checkout-img bg-light d-flex align-items-center justify-content-center text-secondary border">
                                                <i class="bi bi-cup-hot"></i>
                                            </div>
                                        @endif

                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-0 small">{{ $item->product->nama_produk }}</h6>
                                            <span class="small text-muted">{{ $item->jumlah }} x Rp
                                                {{ number_format($item->product->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="fw-bold small">
                                            Rp {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div>
                                <label for="note" class="form-label small fw-bold text-secondary">Catatan untuk Penjual
                                    (Opsional)</label>
                                <textarea name="note" id="note" rows="1"
                                    class="form-control bg-light border-secondary-subtle"
                                    placeholder="Catatan untuk Penjual (Opsional)"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-5">

                    <div class="sticky-top" style="top: 20px; z-index: 900;">

                        <div class="card border-0 shadow-sm rounded-4 mb-3">
                            <div class="card-body p-4">
                                <h5 class="fw-bold fs-6 mb-3"><i class="bi bi-wallet2 me-2 text-custom-green"></i>Metode
                                    Pembayaran</h5>

                                <div class="vstack gap-2">
                                    <label class="payment-card-item" onclick="selectPayment(this)">
                                        <input type="radio" name="payment_method" value="qris" class="d-none" checked>
                                        <i class="bi bi-qr-code-scan fs-4 me-3 text-secondary"></i>
                                        <div>
                                            <span class="small fw-bold d-block">QRIS</span>
                                            <span class="text-muted" style="font-size: 10px;">Scan & Bayar Instan</span>
                                        </div>
                                        <i class="bi bi-check-circle-fill check-icon"></i>
                                    </label>

                                    <label class="payment-card-item" onclick="selectPayment(this)">
                                        <input type="radio" name="payment_method" value="transfer" class="d-none">
                                        <i class="bi bi-bank fs-4 me-3 text-secondary"></i>
                                        <div>
                                            <span class="small fw-bold d-block">Transfer Bank</span>
                                            <span class="text-muted" style="font-size: 10px;">BCA, Mandiri, BRI</span>
                                        </div>
                                        <i class="bi bi-check-circle-fill check-icon"></i>
                                    </label>

                                    <label class="payment-card-item" onclick="selectPayment(this)">
                                        <input type="radio" name="payment_method" value="cod" class="d-none">
                                        <i class="bi bi-cash-coin fs-4 me-3 text-secondary"></i>
                                        <div>
                                            <span class="small fw-bold d-block">Bayar di Tempat (COD)</span>
                                            <span class="text-muted" style="font-size: 10px;">Bayar saat kurir
                                                datang</span>
                                        </div>
                                        <i class="bi bi-check-circle-fill check-icon"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold fs-6 mb-4">Ringkasan Pembayaran</h5>

                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-secondary">Total Harga Barang</span>
                                    <span class="fw-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-secondary">Ongkos Kirim</span>
                                    <span class="fw-medium" id="ongkir-display">Rp
                                        {{ number_format($ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 small">
                                    <span class="text-secondary">Biaya Layanan</span>
                                    <span class="fw-medium">Rp {{ number_format($biayaLayanan, 0, ',', '.') }}</span>
                                </div>

                                <hr class="border-secondary opacity-10">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="fw-bold text-dark">Total Tagihan</span>
                                    <span class="fw-bold fs-4 text-custom-green" id="total-display">Rp
                                        {{ number_format($totalBayar, 0, ',', '.') }}</span>
                                </div>

                                <button type="submit"
                                    class="btn btn-custom-green w-100 py-2 fw-bold shadow-sm rounded-3 d-none d-lg-block">
                                    Bayar Sekarang
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="fixed-bottom-bar d-lg-none d-flex align-items-center justify-content-between">
        <div>
            <span class="small text-muted d-block" style="font-size: 11px;">Total Tagihan</span>
            <span class="fw-bold fs-5 text-custom-green" id="mobile-total-display">Rp
                {{ number_format($totalBayar, 0, ',', '.') }}</span>
        </div>
        <button type="button" onclick="document.getElementById('paymentForm').submit();"
            class="btn btn-custom-green px-5 py-2 fw-bold rounded-3">
            Bayar
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const subtotal = {{ $subtotal }};
        const biayaLayanan = {{ $biayaLayanan }};
        let ongkir = {{ $ongkir }};

        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateShipping(type) {
            const radios = document.getElementsByName('shipping_type');
            radios.forEach(radio => {
                const card = radio.closest('.shipping-card');
                if (radio.value === type) {
                    card.classList.add('active');
                    radio.checked = true;
                } else {
                    card.classList.remove('active');
                }
            });

            if (type === 'pickup') {
                document.getElementById('address-delivery').classList.add('d-none');
                document.getElementById('address-pickup').classList.remove('d-none');

                ongkir = 0;
                document.getElementById('ongkir-display').innerText = "Gratis";
                document.getElementById('ongkir-display').classList.add('text-success');
            } else {
                document.getElementById('address-delivery').classList.remove('d-none');
                document.getElementById('address-pickup').classList.add('d-none');

                ongkir = {{ $ongkir }};
                document.getElementById('ongkir-display').innerText = formatRupiah(ongkir);
                document.getElementById('ongkir-display').classList.remove('text-success');
            }

            let totalBaru = subtotal + ongkir + biayaLayanan;
            document.getElementById('total-display').innerText = formatRupiah(totalBaru);
            document.getElementById('mobile-total-display').innerText = formatRupiah(totalBaru);
        }

        function selectPayment(element) {
            const allOptions = document.querySelectorAll('.payment-card-item');

            allOptions.forEach(opt => {
                opt.classList.remove('active');
                const icon = opt.querySelector('.bi-qr-code-scan, .bi-bank, .bi-cash-coin');
                if (icon) icon.classList.remove('text-custom-green');
            });

            element.classList.add('active');
            const iconActive = element.querySelector('.bi-qr-code-scan, .bi-bank, .bi-cash-coin');
            if (iconActive) iconActive.classList.add('text-custom-green');

            element.querySelector('input').checked = true;
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateShipping('delivery');

            const checkedPayment = document.querySelector('input[name="payment_method"]:checked');
            if (checkedPayment) {
                selectPayment(checkedPayment.closest('.payment-card-item'));
            }
        });
    </script>
</body>

</html>
