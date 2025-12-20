@extends('layouts.about-app')

@section('title', 'Tentang TJAP SATU')

@section('content')
    {{-- 1. LOAD GOOGLE FONTS & CUSTOM CSS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;1,400&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --tjap-green: #2c3e2e;
            --tjap-orange: #d35400;
            --tjap-cream: #f9f7f2;
            --tjap-gold: #c5a059;
        }

        body {
            background-color: var(--tjap-cream);
            font-family: 'Lora', serif;
            color: #4a4a4a;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        /* --- UTILS --- */
        .text-highlight { color: var(--tjap-orange); }
        .bg-cream { background-color: var(--tjap-cream); }
        .letter-spacing-2 { letter-spacing: 2px; }
        .font-serif { font-family: 'Playfair Display', serif; }

        /* --- HERO SECTION --- */
        .hero-title span {
            color: var(--tjap-orange);
            font-style: italic;
        }
        .animate-bounce {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        /* --- STORY SECTION (SIMPLIFIED) --- */
        .story-img-frame {
            position: relative;
        }
        /* Kotak garis di belakang gambar */
        .story-img-frame::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 15px;
            width: 100%;
            height: 100%;
            border: 2px solid var(--tjap-orange); /* Garis oranye tipis */
            border-radius: 8px;
            z-index: 0;
            transition: transform 0.3s ease;
        }
        .story-img-frame:hover::before {
            transform: translate(5px, 5px); /* Efek gerak sedikit saat hover */
        }
        .story-img {
            position: relative;
            z-index: 1;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* --- OWNER CARD --- */
        .owner-card {
            background: white;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .owner-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .owner-img-wrapper {
            height: 280px;
            overflow: hidden;
            background-color: var(--tjap-green);
        }
        .owner-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .owner-card:hover .owner-img { transform: scale(1.1); }

        /* --- INFINITE SLIDER --- */
        .slider-track {
            display: flex;
            width: calc(300px * 8); /* Lebar dikurangi agar gambar lebih rapat */
            animation: scroll 40s linear infinite;
        }
        .slider-img {
            height: 350px; /* Tinggi dikurangi sedikit */
            width: 300px; 
            object-fit: cover;
            filter: brightness(0.9);
        }
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>

    @include('components.header')

    {{-- CONTENT --}}
    <main>
        {{-- Flash message --}}
        @if (session('status'))
            <div class="position-fixed top-0 start-50 translate-middle-x mt-4" style="z-index: 1050;">
                <div class="alert alert-success alert-dismissible fade show shadow-lg" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @include('components.login-modal')

        <section class="hero-section position-relative text-white" style="height: 100vh; overflow: hidden;">
            <video autoplay muted loop playsinline class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                <source src="{{ asset('videos/heroes.mp4') }}" type="video/mp4">
            </video>
            <div class="overlay position-absolute top-0 start-0 w-100 h-100"
                style="background: linear-gradient(to bottom, rgba(44, 62, 46, 0.4), rgba(0, 0, 0, 0.8)); z-index:1;">
            </div>
            <div class="container position-relative h-100 d-flex flex-column justify-content-center align-items-center text-center"
                data-aos="fade-up" data-aos-duration="1200" style="z-index:2;">
                <h1 class="display-3 fw-bold mb-3 hero-title" style="text-shadow: 2px 2px 15px rgba(0,0,0,0.6);">
                    Mari Menyeduh <span>Cerita</span><br>di Seluruh <span>Bandung</span>
                </h1>
                <p class="fs-5 mb-5 opacity-75 fw-light">
                    Menghidupkan kembali nostalgia lewat secangkir kopi otentik.
                </p>
                <a href="#about-story" class="text-white text-decoration-none animate-bounce mt-4 opacity-75">
                    <small class="text-uppercase letter-spacing-2">Scroll Down</small><br>
                    <i class="bi bi-arrow-down fs-4"></i>
                </a>
            </div>
        </section>

        <section id="about-story" class="py-5 bg-white">
            <div class="container py-4"> <div class="row align-items-center gx-5">
                    
                    <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                        <div class="story-img-frame pe-3 pb-3">
                            <img src="{{ asset('images/about.webp') }}" alt="Interior TJAP SATU" class="story-img">
                        </div>
                    </div>

                    <div class="col-lg-7 ps-lg-4" data-aos="fade-left" data-aos-duration="1000">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 me-3 shadow-sm">EST. 2024</span>
                            <div style="height: 1px; width: 50px; background-color: var(--tjap-orange);"></div>
                        </div>

                        <h2 class="display-6 fw-bold mb-3 text-dark">
                            Dari Biji Kopi, <span class="fst-italic text-highlight">Menjadi Satu Hati.</span>
                        </h2>

                        <p class="text-muted lh-lg mb-3">
                            Perjalanan kami bermula dari <strong>Kalle Coffee</strong>, sebuah dedikasi sederhana untuk mendistribusikan biji kopi terbaik. Namun, kami menyadari bahwa kopi bukan hanya tentang rasa, melainkan tentang perasaan.
                        </p>
                        
                        <p class="text-muted lh-lg mb-4">
                            Kini, TJAP SATU hadir dengan konsep <strong>Vintage Asian</strong>. Kami memadukan nostalgia kedai kopi masa lampau dengan kenyamanan modern, menciptakan ruang hangat bagi siapa pun untuk merayakan momen sederhana.
                        </p>

                        <div class="border-start border-4 border-warning ps-3">
                            <p class="fst-italic text-secondary mb-0">"Menyeduh kenangan, satu cangkir demi satu cangkir."</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-5 bg-cream">
            <div class="container">
                <div class="row align-items-center gx-5">
                    <div class="col-lg-5 order-lg-2" data-aos="fade-left">
                        <h6 class="text-uppercase text-secondary letter-spacing-2 mb-2">Philosophy</h6>
                        <h3 class="fw-bold text-dark mb-3">Makna Logo</h3>
                        
                        <div class="vstack gap-3 mt-4">
                            <div class="d-flex bg-white p-3 rounded shadow-sm">
                                <i class="bi bi-circle-fill text-warning me-3 fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Angka "1"</h6>
                                    <small class="text-muted">Tekad menjadi yang terbaik dalam rasa & pelayanan.</small>
                                </div>
                            </div>
                            <div class="d-flex bg-white p-3 rounded shadow-sm">
                                <i class="bi bi-palette-fill text-success me-3 fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Warna Retro</h6>
                                    <small class="text-muted">Hijau (Ketenangan) & Oranye (Kehangatan).</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-7 order-lg-1 text-center mt-4 mt-lg-0" data-aos="fade-right">
                        <img src="{{ asset('images/logo-tjapsatu.png') }}" class="img-fluid"
                            alt="Logo TJAP SATU" style="max-height: 350px; filter: drop-shadow(0px 10px 15px rgba(0,0,0,0.1));">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-white">
            <div class="container py-4">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h6 class="text-uppercase text-secondary letter-spacing-2">The People</h6>
                    <h2 class="fw-bold text-highlight">Pemilik Bisnis</h2>
                    <div class="mx-auto mt-2" style="width: 50px; height: 3px; background-color: var(--tjap-green);"></div>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach ($owners as $owner)
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                            <div class="owner-card h-100 text-center pb-4">
                                <div class="owner-img-wrapper mb-3">
                                    <img src="{{ asset('images/' . $owner['image']) }}" alt="{{ $owner['name'] }}" class="owner-img">
                                </div>
                                <div class="px-3">
                                    <h5 class="fw-bold mb-1 font-serif">{{ $owner['name'] }}</h5>
                                    <p class="small text-uppercase text-warning fw-bold mb-2">{{ $owner['position'] }}</p>
                                    <p class="text-muted small px-2">{{ $owner['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="asal-usul" class="position-relative bg-dark overflow-hidden">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-4 d-flex align-items-center bg-dark text-white p-5 position-relative z-2">
                        <div data-aos="fade-right" class="p-lg-2">
                            <h3 class="fw-bold text-uppercase mb-3" style="color: var(--tjap-gold);">Asal Usul Biji Kopi</h3>
                            <p class="text-white-50 mb-4 small lh-lg">
                                Kurasi terbaik dari <strong>Temanggung, Gayo, dan Toraja</strong>. Diproses penuh cinta untuk menjaga cita rasa otentik.
                            </p>
                            <button class="btn btn-outline-warning btn-sm text-white rounded-pill px-4 py-2">Lihat Menu</button>
                        </div>
                    </div>
                    <div class="col-lg-8 bg-black position-relative overflow-hidden">
                         <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to right, #212529 0%, transparent 10%); z-index: 2;"></div>
                        <div class="slider-track">
                            <img src="{{ asset('images/biji.JPG') }}" class="slider-img">
                            <img src="{{ asset('images/biji.JPG') }}" class="slider-img">
                            <img src="{{ asset('images/biji.JPG') }}" class="slider-img">
                            <img src="{{ asset('images/biji.JPG') }}" class="slider-img">
                            <img src="{{ asset('images/biji.JPG') }}" class="slider-img">
                            <img src="{{ asset('images/biji.JPG') }}" class="slider-img">
                            <img src="{{ asset('images/biji.JPG') }}" class="slider-img">
                            <img src="{{ asset('images/biji.JPG') }}" class="slider-img">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('components.footer')
    </main>
@endsection