@extends('layouts.checkout-app')

@section('title', 'Checkout')

@section('content')
    <div class="container my-5">
        <div class="row">
            <!-- Bag / Cart Items -->
            <div class="col-md-7">
                <!-- Metode Pengiriman -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Pilih Metode Pengiriman</h5>
                    <hr>
                    <!-- Home Delivery -->
                    <div class="shipping-option p-3 mb-3 border rounded d-flex align-items-start">
                        <input class="form-check-input me-3 mt-2" type="radio" name="shipping_method" id="home_delivery"
                            value="home_delivery" checked>
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-truck fs-3 me-3 text-dark"></i>
                                <div>
                                    <label for="home_delivery" class="fw-bold mb-0">Home Delivery</label>
                                    <p class="mb-0 text-muted small">Kami kirimkan order anda ke rumah</p>
                                </div>
                            </div>

                            <!-- Form Alamat (muncul hanya jika Home Delivery dipilih) -->
                            @include('components.checkout.alamat')
                        </div>
                    </div>

                    <!-- Ambil di Toko -->
                    <div class="shipping-option p-3 mb-3 border rounded d-flex align-items-center">
                        <input class="form-check-input me-3" type="radio" name="shipping_method" id="store_pickup"
                            value="store_pickup">
                        <div class="d-flex align-items-center w-100">
                            <i class="bi bi-shop fs-3 me-3 text-dark"></i>
                            <div>
                                <label for="store_pickup" class="fw-bold mb-0">Klik & Ambil di Toko</label>
                                <p class="mb-0 text-muted small">Ambil order anda di toko kami</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bag Items -->
                <h4 class="mb-4">Bag</h4>
                @include('components.checkout.item')

            </div>

            <!-- Summary / Checkout -->
            <div class="col-md-5">
                <h4 class="mb-4">Summary</h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Biaya Pengiriman</span>
                        <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Pajak</span>
                        <span>—</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($subtotal + $shippingCost, 0, ',', '.') }}</span>
                    </li>
                </ul>

                <!-- Metode Pembayaran -->
                <div class="mb-3">
                    <h5 class="fw-bold mb-3">Pilih Metode Pembayaran</h5>
                    <hr>
                    <div class="payment-option p-3 mb-3 border rounded d-flex align-items-center">
                        <input class="form-check-input me-3" type="radio" name="payment_method" id="credit_card"
                            value="credit_card">
                        <div class="d-flex align-items-center w-100">
                            <i class="bi bi-credit-card fs-3 me-3 text-dark"></i>
                            <div>
                                <label for="credit_card" class="fw-bold mb-0">Kartu Kredit</label>
                                <p class="mb-0 text-muted small">Bayar menggunakan kartu debit atau kredit</p>
                            </div>
                        </div>
                    </div>

                    <div class="payment-option p-3 mb-3 border rounded d-flex align-items-center">
                        <input class="form-check-input me-3" type="radio" name="payment_method" id="bank_transfer"
                            value="bank_transfer">
                        <div class="d-flex align-items-center w-100">
                            <i class="bi bi-bank fs-3 me-3 text-dark"></i>
                            <div>
                                <label for="bank_transfer" class="fw-bold mb-0">Transfer Bank</label>
                                <p class="mb-0 text-muted small">Bayar melalui rekening bank Anda</p>
                            </div>
                        </div>
                    </div>

                    <div class="payment-option p-3 mb-3 border rounded d-flex align-items-center">
                        <input class="form-check-input me-3" type="radio" name="payment_method" id="e_wallet"
                            value="e_wallet">
                        <div class="d-flex align-items-center w-100">
                            <i class="bi bi-phone fs-3 me-3 text-dark"></i>
                            <div>
                                <label for="e_wallet" class="fw-bold mb-0">E-Wallet</label>
                                <p class="mb-0 text-muted small">Bayar menggunakan OVO, GoPay, Dana, atau lainnya</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Buttons -->
                <button class="btn btn-dark w-100 mb-2">Bayar Sekarang</button>
            </div>
        </div>
    </div>

    <!-- Script untuk menampilkan alamat hanya jika Home Delivery dipilih -->
    <script>
        const deliveryOption = document.getElementById('home_delivery');
        const pickupOption = document.getElementById('store_pickup');
        const addressForm = document.getElementById('delivery_address');

        function toggleAddress() {
            if (deliveryOption.checked) {
                addressForm.style.display = 'block';
            } else {
                addressForm.style.display = 'none';
            }
        }

        deliveryOption.addEventListener('change', toggleAddress);
        pickupOption.addEventListener('change', toggleAddress);

        toggleAddress();
    </script>
@endsection
