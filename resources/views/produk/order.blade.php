@extends('layouts.app')

@section('title', 'Pesan ' . $produk['nama'])

@section('content')
<style>
    /* Menambahkan style spesifik untuk halaman order */
    .order-summary {
        background-color: rgba(255, 255, 255, 0.7);
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 1.5rem;
    }
    .form-label {
        font-weight: 500;
    }
    #total-harga {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--tjap-red, #C84B31);
    }
</style>

<div class="text-center mb-5">
    <h1 class="header-title">Order Product</h1>
    <p class="lead">Selesaikan pesanan Anda untuk biji kopi {{ $produk['nama'] }}</p>
</div>

<form>
    <div class="row g-5">
        <div class="col-md-7">
            <h4>Detail Pesanan</h4>
            <hr>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="ukuran" class="form-label">Ukuran Kemasan</label>
                    <select class="form-select" id="ukuran" required>
                        @foreach($produk['harga'] as $berat => $harga)
                            <option value="{{ $harga }}">{{ $berat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="gilingan" class="form-label">Tingkat Gilingan</label>
                    <select class="form-select" id="gilingan" required>
                        <option value="Biji Utuh" selected>Biji Utuh (Whole Beans)</option>
                        <option value="Giling Kasar">Giling Kasar (Cold Brew, French Press)</option>
                        <option value="Giling Sedang">Giling Sedang (V60, Aeropress)</option>
                        <option value="Giling Halus">Giling Halus (Espresso, Tubruk)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" value="1" min="1" required>
                </div>
            </div>

            <h4 class="mt-5">Informasi Pengiriman</h4>
            <hr>
            <div class="row g-3">
                <div class="col-12">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" placeholder="Nama Anda" required>
                </div>
                <div class="col-12">
                    <label for="telepon" class="form-label">Nomor Telepon (WhatsApp)</label>
                    <input type="tel" class="form-control" id="telepon" placeholder="081234567890" required>
                </div>
                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" id="alamat" rows="3" placeholder="Jl. Raya Soreang No. 123, Kab. Bandung" required></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="order-summary">
                <h4>Ringkasan Pesanan</h4>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Produk:</span>
                    <strong>{{ $produk['nama'] }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Harga Satuan:</span>
                    <strong id="harga-satuan">Rp 0</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Jumlah:</span>
                    <strong id="jumlah-pesanan">1 Pcs</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Total:</h5>
                    <h5 id="total-harga">Rp 0</h5>
                </div>
                
                <hr>
                <h4 class="mt-4">Metode Pembayaran</h4>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pembayaran" id="bca" checked>
                    <label class="form-check-label" for="bca">
                        Bank Transfer (BCA)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pembayaran" id="qris">
                    <label class="form-check-label" for="qris">
                        QRIS (Gopay, OVO, Dana, dll.)
                    </label>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-success btn-lg">Konfirmasi dan Bayar</button>
                </div>

                <div class="d-grid mt-4">
                    <a href="{{ route('produk.show', ['id' => $produk['id']]) }}" class="btn btn-success btn-lg">
                      Kembali ke Halaman Produk
                </a>
                </div>

    
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
{{-- Sedikit JavaScript untuk membuat ringkasan pesanan menjadi dinamis --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ukuranSelect = document.getElementById('ukuran');
        const jumlahInput = document.getElementById('jumlah');
        const hargaSatuanEl = document.getElementById('harga-satuan');
        const jumlahPesananEl = document.getElementById('jumlah-pesanan');
        const totalHargaEl = document.getElementById('total-harga');

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        function updateTotal() {
            const hargaSatuan = parseFloat(ukuranSelect.value);
            const jumlah = parseInt(jumlahInput.value);
            const total = hargaSatuan * jumlah;

            hargaSatuanEl.textContent = formatRupiah(hargaSatuan);
            jumlahPesananEl.textContent = jumlah + ' Pcs';
            totalHargaEl.textContent = formatRupiah(total);
        }

        // Panggil saat pertama kali halaman dimuat
        updateTotal();

        // Tambahkan event listener untuk setiap perubahan
        ukuranSelect.addEventListener('change', updateTotal);
        jumlahInput.addEventListener('input', updateTotal);
    });
</script>
@endsection