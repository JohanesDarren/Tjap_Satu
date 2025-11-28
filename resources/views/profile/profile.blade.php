@extends('layouts.profile-app')

@section('title', 'Profil Saya')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <div class="profile-container">
        <div class="sidebar">
            <div class="brand">
                <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="/"
                    style="letter-spacing:1px;">
                    <span class="brand-dot"></span> <span class="brand-text">TOKOKOPITJAP1*</span>
                </a>
            </div>
            <ul class="menu">
                <li class="active" onclick="showSection('dataDiri', this)"><i class="bi bi-person-circle"></i> Profil</li>
                <li onclick="showSection('pesanan', this)"><i class="bi bi-bag"></i> Pesanan Saya</li>
                {{-- <li onclick="showSection('alamat', this)"><i class="bi bi-geo-alt"></i> Alamat</li>
                <li onclick="showSection('pengaturan', this)"><i class="bi bi-gear"></i> Pengaturan</li> --}}
                <li onclick="window.location.href='{{ route('home') }}'"><i class="bi bi-box-arrow-right"></i> Keluar</li>
            </ul>
        </div>

        <div class="content">
            {{-- Data Diri --}}
            @include('components.profile.data-diri')

            {{-- Riwayat Pesanan --}}
            @include('components.profile.history')

            <div id="alamat" class="tab-section" style="display:none;">
                <p>Coming Soon.</p>
            </div>

            <div id="pengaturan" class="tab-section" style="display:none;">
                <p>Coming Soon.</p>
            </div>
        </div>
    </div>

@endsection
