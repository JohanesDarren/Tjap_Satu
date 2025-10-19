@extends('layouts.cart-app')
@section('title', 'Keranjang Belanja')
@include('components.header')

@section('content')
    <div class="cart-wrapper">

        <h4 class="fw-bold mb-4">
            <i class="bi bi-cart3 me-2"></i>KERANJANG
        </h4>

        <hr class="line">

        <!-- Tombol Pilih Semua -->
        <div class="mb-3">
            <input type="checkbox" id="select-all" class="form-check-input me-2">
            <label for="select-all" class="form-check-label fw-semibold">Pilih Semua</label>
        </div>

        <!-- Bagian Table -->
        @include('components.cart.table')

        <!-- Bagian Promo / Kode Voucher -->
        @include('components.cart.voucher')


        <div class="cart-footer">
            <div class="total-box">
                <strong>TOTAL</strong>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="mt-3 text-end">
                <button class="btn btn-checkout" onclick="window.location.href='{{ route('checkout.index') }}'">CHECK
                    OUT</button>
            </div>
        </div>

        <hr class="my-5">

    </div>

@endsection

