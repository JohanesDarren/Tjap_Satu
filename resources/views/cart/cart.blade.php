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
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; color: #1f2937; padding-bottom: 120px; }
        
        /* Custom Colors */
        :root {
            --primary-green: #325B56;
            --hover-green: #264541;
            --light-green: #eef5f4;
        }

        .text-custom-green { color: var(--primary-green); }
        .bg-custom-green { background-color: var(--primary-green); color: white; }
        
        .btn-custom-green { background-color: var(--primary-green); color: white; border: none; transition: 0.3s; }
        .btn-custom-green:hover { background-color: var(--hover-green); color: white; }
        .btn-custom-green:disabled { background-color: #a0b1af; }

        .btn-outline-green { border-color: var(--primary-green); color: var(--primary-green); }
        .btn-outline-green:hover { background-color: var(--primary-green); color: white; }

        .cart-item-img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; }
        
        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* Voucher Styles */
        .voucher-applied-card {
            background-color: var(--light-green);
            border: 2px dashed var(--primary-green);
            position: relative;
        }
        
        .divider-text {
            display: flex;
            align-items: center;
            text-align: center;
            color: #adb5bd;
            font-size: 0.8rem;
            margin: 10px 0;
        }
        .divider-text::before, .divider-text::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }
        .divider-text::before { margin-right: .5em; }
        .divider-text::after { margin-left: .5em; }

        /* Mobile Header */
        .mobile-header {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            z-index: 1000;
            border-bottom: 1px solid #eee;
        }

        /* Fixed Bottom Bar */
        .fixed-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 15px 20px;
            box-shadow: 0 -4px 25px rgba(0,0,0,0.08);
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
        <div style="width: 24px;"></div> </div>

    <div class="container py-4 py-md-5 mt-5 mt-md-0" style="max-width: 900px;">

        <div class="d-none d-md-block mb-4">
            <a href="/menu" class="text-decoration-none text-secondary d-inline-flex align-items-center hover-dark">
                <i class="bi bi-arrow-left me-2"></i>
                <span class="fw-medium small">Kembali ke Menu</span>
            </a>
        </div>

        <h1 class="h3 fw-bold mb-4 d-none d-md-block text-secondary">Keranjang Saya</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('promo_success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0 bg-success text-white" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('promo_success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('promo_error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('promo_error') }}
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
                                <label class="form-check-label fw-medium ms-2 user-select-none" for="selectAll">
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
                                            @if($item->product->gambar)
                                                <img src="{{ asset('uploads/' . $item->product->gambar) }}" class="cart-item-img shadow-sm" alt="Produk">
                                            @else
                                                <div class="cart-item-img bg-light d-flex align-items-center justify-content-center text-secondary rounded-3">
                                                    <i class="bi bi-cup-hot fs-3"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="fw-bold mb-1 text-dark">{{ $item->product->nama_produk }}</h6>
                                                    <p class="text-custom-green fw-bold mb-2">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                                </div>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id_item }}').submit();" class="text-danger opacity-75 hover-opacity-100 p-2">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div class="d-flex align-items-center border rounded-3 px-1 py-1 bg-white" style="width: fit-content;">
                                                    <a href="{{ route('cart.update', ['id_item' => $item->id_item, 'action' => 'minus']) }}" class="btn btn-sm text-dark border-0 py-0 px-2 fw-bold">-</a>
                                                    <span class="px-2 small fw-bold" style="min-width: 25px; text-align: center;">{{ $item->jumlah }}</span>
                                                    <a href="{{ route('cart.update', ['id_item' => $item->id_item, 'action' => 'plus']) }}" class="btn btn-sm text-dark border-0 py-0 px-2 fw-bold">+</a>
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

                    <div class="card border-0 shadow-sm rounded-4 mt-3 d-lg-none">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-3 d-flex align-items-center">
                                <i class="bi bi-ticket-perforated me-2 text-custom-green"></i> Voucher & Promo
                            </h6>
                            
                            @if($appliedPromo)
                                <div class="voucher-applied-card rounded-3 p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white text-custom-green rounded-circle p-2 me-3 shadow-sm">
                                            <i class="bi bi-check-lg fw-bold"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-custom-green">{{ $appliedPromo->code }}</div>
                                            <div class="small text-muted">{{ $appliedPromo->title }}</div>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.remove-promo') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none fw-bold small">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @else
                                @if(count($availablePromos) > 0)
                                    <form action="{{ route('cart.apply-promo') }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-0">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-tag"></i></span>
                                            <select class="form-select border-start-0 ps-0" name="promo_code" onchange="this.form.submit()">
                                                <option value="">Pilih Voucher Tersedia</option>
                                                @foreach($availablePromos as $promo)
                                                    <option value="{{ $promo->code }}">
                                                        {{ $promo->code }} - 
                                                        @if($promo->discount_type === 'percentage') {{ $promo->discount_value }}% OFF
                                                        @else Rp {{ number_format($promo->discount_value, 0, ',', '.') }} OFF @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                    <div class="divider-text">atau punya kode lain?</div>
                                @endif
                                
                                <form action="{{ route('cart.apply-promo') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="promo_code" class="form-control" placeholder="Masukkan kode voucher" style="text-transform: uppercase;">
                                        <button type="submit" class="btn btn-custom-green px-3">Pakai</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 d-none d-lg-block">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 90px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                            
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted mb-2">Voucher & Promo</label>
                                
                                @if($appliedPromo)
                                    <div class="voucher-applied-card rounded-3 p-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="d-flex gap-2">
                                                <i class="bi bi-ticket-perforated-fill text-custom-green fs-5"></i>
                                                <div>
                                                    <h6 class="fw-bold text-custom-green mb-0">{{ $appliedPromo->code }}</h6>
                                                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem; line-height: 1.2;">{{ $appliedPromo->title }}</small>
                                                </div>
                                            </div>
                                            <form action="{{ route('cart.remove-promo') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-close" style="width: 0.5em; height: 0.5em;" title="Hapus Promo"></button>
                                            </form>
                                        </div>
                                        <div class="mt-2 pt-2 border-top border-secondary border-opacity-10 text-success small fw-medium">
                                            <i class="bi bi-check-circle me-1"></i> Voucher berhasil dipasang!
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-light p-3 rounded-3">
                                        @if(count($availablePromos) > 0)
                                            <form action="{{ route('cart.apply-promo') }}" method="POST" class="mb-2">
                                                @csrf
                                                <select class="form-select form-select-sm border-0 shadow-none bg-white py-2" name="promo_code" onchange="this.form.submit()">
                                                    <option value="">Pilih Voucher Hemat</option>
                                                    @foreach($availablePromos as $promo)
                                                        <option value="{{ $promo->code }}">
                                                            {{ $promo->code }} (Hemat @if($promo->discount_type === 'percentage') {{ $promo->discount_value }}% @else {{ number_format($promo->discount_value/1000) }}rb @endif)
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                            
                                            <div class="divider-text my-2">atau input manual</div>
                                        @endif
                                        
                                        <form action="{{ route('cart.apply-promo') }}" method="POST">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="promo_code" class="form-control border-0 shadow-none" placeholder="Kode Promo" style="text-transform: uppercase;">
                                                <button type="submit" class="btn btn-custom-green px-3">Pakai</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Harga</span>
                                <span class="fw-bold" id="desktopTotal">Rp 0</span>
                            </div>

                            @if($appliedPromo)
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span><i class="bi bi-tag-fill me-1"></i> Diskon</span>
                                    <span class="fw-bold">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <hr class="border-secondary opacity-10 my-3">

                            <div class="d-flex justify-content-between mb-4 align-items-center">
                                <span class="fw-bold text-dark">Total Akhir</span>
                                <span class="fs-4 fw-bold text-custom-green" id="desktopFinalTotal">Rp 0</span>
                            </div>

                            <button type="button" onclick="submitCheckout()" class="btn btn-custom-green w-100 py-3 fw-bold shadow-sm rounded-3 btn-checkout">
                                Checkout (<span class="count-selected">0</span>)
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="text-center py-5 my-5">
                <div class="mb-4 opacity-50">
                    <div class="bg-light rounded-circle d-inline-flex p-4">
                        <i class="bi bi-cart-x text-custom-green" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <h4 class="fw-bold">Keranjang Belanjamu Kosong</h4>
                <p class="text-muted mb-4">Sepertinya kamu belum memesan kopi hari ini.</p>
                <a href="/menu" class="btn btn-custom-green px-5 py-2 rounded-pill shadow-sm hover-scale">
                    <i class="bi bi-cup-hot me-2"></i>Lihat Menu
                </a>
            </div>
        @endif

    </div>

    <div class="fixed-bottom-bar d-lg-none d-flex align-items-center justify-content-between">
        <div>
            <span class="small text-muted d-block" style="font-size: 11px;">Total Pembayaran</span>
            <div class="d-flex align-items-center">
                <span class="fw-bold fs-5 text-custom-green me-2" id="mobileFinalTotal">Rp 0</span>
                @if($appliedPromo)
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small px-2">Hemat Rp {{ number_format($discount/1000, 0) }}rb</span>
                @endif
            </div>
        </div>
        <button type="button" onclick="submitCheckout()" class="btn btn-custom-green px-4 py-2 fw-bold rounded-3 btn-checkout shadow-sm">
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
            const desktopTotalEl = document.getElementById('desktopTotal');
            const desktopFinalTotalEl = document.getElementById('desktopFinalTotal');
            const mobileFinalTotalEl = document.getElementById('mobileFinalTotal');
            const countDisplays = document.querySelectorAll('.count-selected');
            const checkoutBtns = document.querySelectorAll('.btn-checkout');

            const discount = {{ $discount ?? 0 }};
            const hasPromo = {{ $appliedPromo ? 'true' : 'false' }};

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

                // Update total harga sebelum diskon
                if(desktopTotalEl) desktopTotalEl.innerText = formatRupiah(total);

                // Hitung total akhir dengan diskon
                let finalTotal = total;
                if(hasPromo && total > 0) {
                    finalTotal = total - discount;
                    if(finalTotal < 0) finalTotal = 0;
                }

                // Update total akhir
                if(desktopFinalTotalEl) desktopFinalTotalEl.innerText = formatRupiah(finalTotal);
                if(mobileFinalTotalEl) mobileFinalTotalEl.innerText = formatRupiah(finalTotal);

                countDisplays.forEach(el => el.innerText = count);
                checkoutBtns.forEach(btn => { 
                    btn.disabled = (count === 0); 
                    if(count === 0) {
                        btn.classList.add('opacity-50');
                    } else {
                        btn.classList.remove('opacity-50');
                    }
                });
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