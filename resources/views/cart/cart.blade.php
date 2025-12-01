<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Toko Kopi Tjap Satu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; color: #1f2937; padding-bottom: 100px; }

        .text-custom-green { color: #325B56; }
        .bg-custom-green { background-color: #325B56; color: white; }
        .btn-custom-green { background-color: #325B56; color: white; border: none; }
        .btn-custom-green:hover { background-color: #264541; color: white; }
        .btn-custom-green:disabled { background-color: #a0b1af; }

        .cart-item-img { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; }

        .form-check-input:checked {
            background-color: #325B56;
            border-color: #325B56;
        }

        /* Mobile Header (Persis Profil) */
        .mobile-header {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            z-index: 1000;
        }

        /* Fixed Bottom Bar */
        .fixed-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 12px 15px; /* Padding dikurangi sedikit */
            box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
            z-index: 1000;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>

    <div class="fixed-top d-md-none mobile-header shadow-sm px-3 py-3 d-flex justify-content-between align-items-center">
        <a href="/menu" class="text-decoration-none text-secondary d-flex align-items-center">
            <i class="bi bi-arrow-left me-2 fs-5"></i>
            <span class="fw-medium">Menu</span>
        </a>
        <span class="fw-bold text-dark">Keranjang Saya</span>
    </div>

    <div class="container py-4 py-md-5 mt-5 mt-md-0" style="max-width: 900px;">

        <div class="d-none d-md-block mb-4">
            <a href="/menu" class="text-decoration-none text-secondary d-inline-flex align-items-center hover-dark">
                <i class="bi bi-arrow-left me-2"></i>
                <span class="fw-medium small">Kembali ke Menu</span>
            </a>
        </div>

        <h1 class="h3 fw-bold mb-4 d-none d-md-block text-secondary">Keranjang Saya</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(count($cartItems) > 0)
            <div class="row g-4">

                <div class="col-lg-8">

                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body py-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll" checked>
                                <label class="form-check-label fw-medium ms-2" for="selectAll">
                                    Pilih Semua ({{ count($cartItems) }})
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-0">
                            <form id="checkoutForm" action="{{ route('checkout.index') }}" method="GET">

                                @foreach($cartItems as $item)
                                <div class="p-3 border-bottom {{ $loop->last ? 'border-0' : '' }}">
                                    <div class="d-flex align-items-start gap-3">

                                        <div class="pt-4">
                                            <input class="form-check-input item-checkbox" type="checkbox"
                                                   name="selected_items[]"
                                                   value="{{ $item->id_item }}"
                                                   data-price="{{ $item->product->harga }}"
                                                   data-qty="{{ $item->jumlah }}"
                                                   checked>
                                        </div>

                                        <div class="flex-shrink-0">
                                            @php
                                                $g = $item->product->gambar ?? null;
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
                                                    } elseif (\Illuminate\Support\Str::startsWith($g, 'images/')) {
                                                        $imgSrc = asset($g);
                                                    } elseif (\Illuminate\Support\Str::startsWith($g, '/')) {
                                                        $imgSrc = asset(ltrim($g, '/'));
                                                    } else {
                                                        $imgSrc = asset('uploads/' . ltrim($g, '/'));
                                                    }
                                                }
                                            @endphp
                                            @if($imgSrc)
                                                <img src="{{ $imgSrc }}" class="cart-item-img" alt="Produk">
                                            @else
                                                <div class="cart-item-img bg-light d-flex align-items-center justify-content-center text-secondary">
                                                    <i class="bi bi-cup-hot fs-3"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="fw-bold mb-1">{{ $item->product->nama_produk }}</h6>
                                                    <p class="text-custom-green fw-bold mb-2">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                                </div>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id_item }}').submit();" class="text-secondary">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div class="d-flex align-items-center border rounded px-2 py-1" style="width: fit-content;">
                                                    <a href="{{ route('cart.update', ['id_item' => $item->id_item, 'action' => 'minus']) }}" class="text-dark text-decoration-none px-2">-</a>
                                                    <span class="fw-bold px-2 small">{{ $item->jumlah }}</span>
                                                    <a href="{{ route('cart.update', ['id_item' => $item->id_item, 'action' => 'plus']) }}" class="text-dark text-decoration-none px-2">+</a>
                                                </div>

                                                <span class="small text-muted">
                                                    Subtotal: <span class="fw-bold text-dark">Rp {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 d-none d-lg-block">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 90px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total Harga</span>
                                <span class="fw-bold" id="desktopTotal">Rp 0</span>
                            </div>

                            <hr class="border-secondary opacity-10">

                            <button type="button" onclick="submitCheckout()" class="btn btn-custom-green w-100 py-2 fw-bold shadow-sm rounded-3 btn-checkout">
                                Beli (<span class="count-selected">0</span>)
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4 opacity-50">
                    <i class="bi bi-bag-x" style="font-size: 4rem; color: #325B56;"></i>
                </div>
                <h4 class="fw-bold">Keranjang Kosong</h4>
                <p class="text-muted">Yuk isi dengan kopi favoritmu!</p>
                <a href="/menu" class="btn btn-custom-green px-5 py-2 rounded-pill">Lihat Menu</a>
            </div>
        @endif

    </div>

    <div class="fixed-bottom-bar d-lg-none d-flex align-items-center justify-content-between">
        <div>
            <span class="small text-muted d-block" style="font-size: 11px;">Total Pembayaran</span>
            <span class="fw-bold fs-5 text-custom-green" id="mobileTotal">Rp 0</span>
        </div>
        <button type="button" onclick="submitCheckout()" class="btn btn-custom-green px-5 py-2 fw-bold rounded-3 btn-checkout">
            Beli (<span class="count-selected">0</span>)
        </button>
    </div>

    @foreach($cartItems as $item)
        <form id="delete-form-{{ $item->id_item }}" action="{{ route('cart.remove', $item->id_item) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const selectAll = document.getElementById('selectAll');
            const totalDisplays = [document.getElementById('desktopTotal'), document.getElementById('mobileTotal')];
            const countDisplays = document.querySelectorAll('.count-selected');
            const checkoutBtns = document.querySelectorAll('.btn-checkout');

            function formatRupiah(angka) {
                return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function calculateTotal() {
                let total = 0;
                let count = 0;

                checkboxes.forEach(chk => {
                    if(chk.checked) {
                        let price = parseFloat(chk.getAttribute('data-price'));
                        let qty = parseInt(chk.getAttribute('data-qty'));
                        total += (price * qty);
                        count++;
                    }
                });

                totalDisplays.forEach(el => { if(el) el.innerText = formatRupiah(total); });
                countDisplays.forEach(el => el.innerText = count);
                checkoutBtns.forEach(btn => { btn.disabled = (count === 0); });
            }

            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(chk => { chk.checked = selectAll.checked; });
                    calculateTotal();
                });
            }

            checkboxes.forEach(chk => {
                chk.addEventListener('change', function() {
                    if(!this.checked) { if(selectAll) selectAll.checked = false; }
                    if(document.querySelectorAll('.item-checkbox:checked').length === checkboxes.length) {
                        if(selectAll) selectAll.checked = true;
                    }
                    calculateTotal();
                });
            });

            calculateTotal();
        });

        function submitCheckout() {
            document.getElementById('checkoutForm').submit();
        }
    </script>
</body>
</html>
