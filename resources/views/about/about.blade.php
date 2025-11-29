@extends('layouts.about-app')

@section('title', 'Tentang TJAP SATU')

@section('content')
  @extends('components.header')

  {{-- CONTENT --}}
  <main>
    {{-- Flash message (opsional) --}}
    @if(session('status'))
      <div class="container pt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    @yield('content')
  </main>

  {{-- LOGIN MODAL (selalu tersedia di layout) --}}
  @include('components.login-modal')

  <!-- HERO SECTION -->
  <section class="hero-section position-relative text-white" style="height: 100vh; overflow: hidden;">

    <!-- Video Background -->
    <video autoplay muted loop playsinline class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
      <source src="{{ asset('videos/heroes.mp4') }}" type="video/mp4">
      Browser kamu tidak mendukung video HTML5.
    </video>

    <!-- Overlay gradasi -->
    <div class="overlay position-absolute top-0 start-0 w-100 h-100"
      style="background: linear-gradient(to top, rgba(60, 30, 10, 0.8), rgba(0, 0, 0, 0.4)); z-index:1;">
    </div>

    <!-- Konten teks di atas video -->
    <div
      class="container position-relative h-100 d-flex flex-column justify-content-end align-items-start text-start pb-5"
      data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" style="z-index:2;">
      <h1 class="display-5 fw-bold mb-3">
        Mari Menyeduh <span>Cerita</span> di<br>
        Seluruh <span>Bandung</span>
      </h1>
      <p class="fs-5">
        Jadilah bagian dari perjalanan kopi nomor satu — TJAP SATU.
      </p>
    </div>

  </section>

  <!-- ABOUT CONTENT -->
  <section class="py-5">
    <div class="container">
      <!-- Cerita Singkat -->
      <div class="row align-items-center mb-5">
        <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">
          <h2 class="fw-bold mb-3 text-dark">Cerita Singkat <span>TJAP SATU</span></h2>
          <p class="text-muted">
            TJAP SATU lahir dari semangat menghadirkan cita rasa kopi terbaik di Kabupaten Bandung.
            Berawal dari Kalle Coffee yang fokus pada distribusi biji kopi, TJAP SATU berkembang menjadi
            sebuah kedai kopi bergaya <em>vintage Asian</em> yang menyajikan pengalaman hangat dan autentik.
          </p>
          <p class="text-muted">
            Dengan suasana klasik dan nuansa oriental, TJAP SATU menjadi ruang bagi siapa pun untuk menikmati kopi,
            berbincang santai, dan merayakan momen sederhana bersama orang terdekat.
          </p>
        </div>
        <div class="col-md-5 text-center" style="margin-left: auto;" data-aos="fade-left" data-aos-duration="1000">
          <img src="{{ asset('images/about.webp') }}" class="img-fluid rounded shadow" alt="Kopi TJAP SATU">
        </div>
      </div>
    </div>
  </section>

  <!-- Filosofi Logo -->
  <section class="py-5">
    <div class="container">
      <div class="row mt-5 align-items-center" style="margin-bottom: 80px;">
        <div class="col-md-6 order-md-2" data-aos="fade-left" data-aos-duration="1000">
          <h3 class="fw-bold text-dark">Filosofi Logo TJAP SATU</h3>
          <p class="fs-5 fw-semibold" style="color:#ff5500;">
            Simbol Semangat Nomor Satu dalam Setiap Seduhan Kopi
          </p>
          <p class="text-muted">
            Logo TJAP SATU mengusung gaya retro-vintage dengan komposisi warna hijau, oranye, dan krem
            yang terinspirasi dari toko-toko kopi klasik Asia. Angka “1” menjadi lambang tekad untuk menjadi
            yang terbaik di Kabupaten Bandung — bukan hanya dalam rasa kopi, tetapi juga dalam pelayanan
            dan pengalaman bagi setiap pelanggan.
          </p>
          <p class="text-muted">
            Warna <span class="fw-semibold">oranye kemerahan</span> memberi kesan hangat, bahagia, dan optimis,
            sedangkan <span class="fw-semibold">hijau tua</span> melambangkan ketenangan dan keseimbangan — seperti
            secangkir kopi yang menenangkan pikiran di tengah kesibukan.
          </p>
        </div>
        <div class="col-md-6 order-md-1 text-center" data-aos="fade-right" data-aos-duration="1000">
          <img src="{{ asset('images/logo-tjapsatu.png') }}" class="img-fluid rounded shadow" alt="Logo TJAP SATU"
            style="max-width: 80%;">
        </div>
      </div>
    </div>
  </section>

  <!-- Pemilik Bisnis -->
  <section class="py-5">
    <div class="container text-center">
      <h2 class="fw-bold text-uppercase" style="color:#ff5500" data-aos="zoom-in" data-aos-duration="1000">Pemilik Bisnis
      </h2>

      <div class="row g-4 justify-content-center">
        @foreach ($owners as $owner)
          <div class="col-md-3 text-center" data-aos="flip-left" data-aos-delay="{{ $loop->index * 300 }}"
            data-aos-duration="1000">
            <div class="owner-card shadow p-3">
              <img src="{{ asset('images/' . $owner['image']) }}" alt="{{ $owner['name'] }}" class="owner-img mb-3">
              <h5 class="fw-bold">{{ $owner['name'] }}</h5>
              <small class="text-muted">{{ $owner['position'] }}</small>
              <p class="mt-2">{{ $owner['desc'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Asal-usul Biji Kopi -->
  <section id="asal-usul" class="py-5 position-relative overflow-hidden">
    <div class="container text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
      <h2 class="fw-bold text-uppercase" style="color:#ff5500;">Asal Usul Biji Kopi</h2>
      <p class="text-muted mt-3 px-md-5">
        Biji kopi TJAP SATU berasal dari petani lokal di berbagai daerah nusantara. Kami memilih biji kopi terbaik
        dari Temanggung, Gayo, dan Toraja — ditanam dengan cinta, dipanen dengan teliti, dan diproses dengan semangat
        menjaga cita rasa otentik Indonesia.
      </p>
    </div>

    <div class="slider-container position-relative" style="height:400px;" data-aos="fade-up" data-aos-delay="300"
      data-aos-duration="1200">
      <div class="slider-track d-flex">
        <img src="{{ asset('images/biji.JPG') }}" class="slider-img" alt="Kopi 1">
        <img src="{{ asset('images/biji.JPG') }}" class="slider-img" alt="Kopi 2">
        <img src="{{ asset('images/biji.JPG') }}" class="slider-img" alt="Kopi 3">
        <img src="{{ asset('images/biji.JPG') }}" class="slider-img" alt="Kopi 4">
        <!-- duplikasi agar animasi looping mulus -->
        <img src="{{ asset('images/biji.JPG') }}" class="slider-img" alt="Kopi 1">
        <img src="{{ asset('images/biji.JPG') }}" class="slider-img" alt="Kopi 2">
        <img src="{{ asset('images/biji.JPG') }}" class="slider-img" alt="Kopi 3">
        <img src="{{ asset('images/biji.JPG') }}" class="slider-img" alt="Kopi 4">
      </div>

      <div
        class="overlay-text position-absolute top-50 start-50 translate-middle text-white text-center px-4 py-3 rounded"
        style="background: rgba(0, 0, 0, 0.21); max-width: 600px;" data-aos="zoom-in" data-aos-delay="500"
        data-aos-duration="1200">
        <h4 class="fw-bold">Dari Petani Lokal untuk Dunia</h4>
        <p style="font-size: 0.95rem;">Kami percaya kopi terbaik datang dari tangan yang tulus dan tanah yang subur.
          Setiap biji yang kami pilih adalah wujud kerja keras dan cinta dari petani Indonesia.</p>
      </div>
    </div>
  </section>


  @include('components.footer')
@endsection