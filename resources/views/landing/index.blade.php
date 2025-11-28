<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root { --bg:#F3E3C2; --coffee:#55351D; --ink:#2E373D; --rust:#AF461F; --teal:#325B56; --surface:#fff; --shadow:0 20px 50px rgba(46,55,61,.18); --radius-xl:24px; --radius-2xl:1.6rem; }
        * { scroll-behavior: smooth; }
        body { background:var(--bg); color:var(--ink); font-family:Poppins,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif; overflow-x:hidden; }
        h1,h2,h3,h4 { font-family:"Playfair Display",serif; color:var(--coffee); letter-spacing:.02em; }
        .hero { position:relative; min-height:100vh; overflow:hidden; isolation:isolate; }
        .hero video { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:contrast(1.06) saturate(1.05) brightness(.95); }
        .hero::after { content:""; position:absolute; inset:0; z-index:1; background:linear-gradient(to top, rgba(0,0,0,.55) 0%, rgba(0,0,0,.25) 60%, rgba(0,0,0,0) 100%); }
        .hero-content { position:relative; z-index:2; min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:flex-end; padding:9rem 1rem 11rem; text-align:center; color:#fff; text-shadow:0 2px 20px rgba(0,0,0,.5); }
        .kicker { text-transform:uppercase; letter-spacing:.28em; font-weight:600; opacity:.9; }
        .btn-pill { border-radius:999px; padding:.9rem 1.2rem; font-weight:600; letter-spacing:.02em; box-shadow:0 10px 24px rgba(175,70,31,.25); }
        .btn-rust { background:var(--rust); color:#fff; border:none; }
        .btn-rust:hover { filter:brightness(.95) saturate(1.03); }
        .btn-ghost { border:1px solid rgba(255,255,255,.6); color:#fff; background:rgba(255,255,255,.08); }
        .btn-ghost:hover { background:rgba(255,255,255,.16); }
        .scroll-cue { position:absolute; bottom:1.25rem; left:50%; transform:translateX(-50%); color:#fff; opacity:.85; font-size:.95rem; }
        .divider-bottom { line-height:0; }
        .divider-bottom svg { display:block; width:100%; height:70px; }
        .strip { --gap:26px; --h:190px; --w:260px; --speed:28s; position:relative; overflow:hidden; padding-block:26px; background:linear-gradient(180deg,#f8edd0,var(--bg)); mask-image:linear-gradient(to right, transparent, #000 8%, #000 92%, transparent); border-top:1px solid rgba(46,55,61,.06); border-bottom:1px solid rgba(46,55,61,.06); }
        .track { display:flex; gap:var(--gap); width:max-content; will-change:transform; animation:marquee var(--speed) linear infinite; }
        @keyframes marquee { to { transform: translateX(calc(-50% - var(--gap))); } }
        .chip { width:var(--w); height:var(--h); flex:0 0 auto; border-radius:18px; overflow:hidden; background:var(--surface); box-shadow:var(--shadow); border:1px solid rgba(46,55,61,.06); }
        .chip img { width:100%; height:60%; object-fit:cover; display:block; }
        .chip .meta { padding:.75rem .9rem; display:flex; align-items:center; justify-content:space-between; }
        .chip .name { color:var(--coffee); font-weight:700; }
        .chip .price { background:var(--teal); color:#fff; padding:.25rem .6rem; border-radius:999px; font-size:.85rem; }
        section.section { padding:84px 0; scroll-margin-top: 84px; }
        .lead-muted { color:#5a676c; opacity:.9; }
        .rounded-2xl { border-radius:var(--radius-2xl); }
        .card-elev { background:var(--surface); border:none; border-radius:var(--radius-xl); box-shadow:var(--shadow); transform:translateY(38px); opacity:0; transition:transform .45s ease, box-shadow .28s ease, filter .28s ease; border:1px solid rgba(46,55,61,.06); }
        .card-elev:hover { transform:translateY(-6px); box-shadow:0 28px 70px rgba(0,0,0,.24); filter:saturate(1.04) contrast(1.02); }
        .card-elev img { height:230px; object-fit:cover; }
        .card-elev .btn-outline-dark { transition:transform .2s ease, box-shadow .2s ease; }
        .card-elev .btn-outline-dark:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(0,0,0,.16); }
        .map-preview { position:relative; height:380px; border-radius:var(--radius-2xl); background:radial-gradient(120px 120px at 20% 30%, rgba(50,91,86,.20), transparent 60%), radial-gradient(160px 120px at 70% 60%, rgba(175,70,31,.16), transparent 60%), linear-gradient(180deg, #f7ead0, var(--bg)); box-shadow:var(--shadow); border:1px solid rgba(46,55,61,.08); overflow:hidden; }
        .map-pin { position:absolute; inset:0; display:grid; place-items:center; }
        .map-pin svg { width:82px; height:82px; filter:drop-shadow(0 10px 20px rgba(0,0,0,.25)); }
        .map-hint { position:absolute; bottom:14px; right:16px; background:#fff; color:var(--ink); padding:.45rem .75rem; border-radius:999px; font-size:.9rem; box-shadow:var(--shadow); }
        .reveal { opacity:0; transform:translateY(30px); }
        .title-underline { position:relative; display:inline-block; }
        .title-underline::after { content:""; position:absolute; left:6px; right:-6px; bottom:-8px; height:8px; border-radius:999px; background:linear-gradient(90deg, var(--rust), var(--teal)); opacity:.25; }
        .text-teal { color:var(--teal); }
        .bg-sand { background:var(--bg); }
        .text-rust { color:var(--rust); }
        .testimonial { background:var(--surface); border-radius:var(--radius-xl); box-shadow:var(--shadow); padding:1.25rem; border:1px solid rgba(46,55,61,.06); }
        .avatar { width:48px; height:48px; border-radius:50%; object-fit:cover; }
        footer { background:linear-gradient(180deg, var(--bg), #e8d8b4); border-top:1px solid rgba(46,55,61,.08); }

        /* Glass Register Card */
        .glass-card{
            position:relative;
            background:linear-gradient(180deg, rgba(255,255,255,.24), rgba(255,255,255,.14));
            border:1px solid rgba(255,255,255,.35);
            box-shadow:0 18px 60px rgba(46,55,61,.22);
            border-radius:24px;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            overflow:hidden;
        }
        .glass-card::before{
            content:""; position:absolute; inset:0; pointer-events:none;
            background: radial-gradient(280px 140px at -10% -20%, rgba(175,70,31,.18), transparent 60%),
                        radial-gradient(320px 180px at 110% 120%, rgba(50,91,86,.16), transparent 60%);
        }
        .glass-title{ color:var(--coffee); letter-spacing:.02em; }

        .glass-input{
            background: rgba(255,255,255,.65);
            border:1px solid rgba(46,55,61,.22);
            border-radius:14px; padding: .9rem 1rem; height:auto;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .glass-input:focus{
            background: rgba(255,255,255,.85);
            border-color: rgba(175,70,31,.6);
            box-shadow: 0 0 0 .15rem rgba(175,70,31,.25);
        }
        .input-label{ font-weight:600; color:#3a454b; }
        .helper-text{ color:#6b767b; font-size:.9rem; }

        .btn-gradient{
            background: linear-gradient(135deg, var(--rust), #c96931);
            color:#fff; border:none; border-radius:999px;
            padding:.9rem 1.2rem; font-weight:700; letter-spacing:.02em;
            box-shadow:0 14px 30px rgba(175,70,31,.28);
        }
        .btn-gradient:hover{ filter:brightness(.98) saturate(1.04); }
        .link-rust{ color:var(--rust); }
        .link-rust:hover{ color:#c96931; }

        .pw-wrap{ position:relative; }
        .pw-toggle{
            position:absolute; right:.6rem; top:50%; transform:translateY(-50%);
            border:none; background:transparent; padding:.35rem; color:#6b767b;
        }

        /* ===== Menu Card Hover Enhancements ===== */
        .product-card { overflow: hidden; border-radius: var(--radius-xl); }
        .product-card .product-img { transition: transform .7s cubic-bezier(.2,.75,.2,1), filter .5s ease; will-change: transform; }
        .product-card:hover .product-img { transform: scale(1.06); filter: saturate(1.04) contrast(1.02); }
        .product-card::after{ content:""; position:absolute; inset:auto auto 0 0; width:65%; height:40%; pointer-events:none; background:radial-gradient(240px 120px at 0% 100%, rgba(175,70,31,.18), transparent 60%); opacity:.0; transition:opacity .45s ease; }
        .product-card:hover::after{ opacity:1; }
        .product-card:hover{ box-shadow:0 28px 70px rgba(46,55,61,.24); }
        .product-card .btn-outline-dark{ transition: transform .2s ease, box-shadow .2s ease, background .25s ease, color .25s ease, border-color .25s ease; }
        .product-card:hover .btn-outline-dark{ background: var(--rust); color:#fff; border-color: var(--rust); transform: translateY(-2px); box-shadow:0 8px 18px rgba(175,70,31,.35); }
        .product-card .price-label{ background: rgba(50,91,86,.12); color: var(--ink); padding:.25rem .6rem; border-radius:999px; font-weight:700; transition: transform .25s ease, background .25s ease; }
        .product-card:hover .price-label{ background: rgba(50,91,86,.18); transform: translateY(-1px); }

        /* Keyboard focus styles */
        .product-card:focus-within { outline: 2px solid rgba(175,70,31,.55); outline-offset: 3px; }
        .product-card .btn-outline-dark:focus-visible { box-shadow: 0 0 0 .18rem rgba(175,70,31,.35); }

        /* Respect reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .product-card .product-img { transition: none; }
            .product-card:hover .product-img { transform: none; filter: none; }
            .card-elev, .reveal { transition: none !important; }
            .track { animation: none !important; }
        }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @extends('layouts.app')

    <!-- HERO -->
    <header class="hero">
        <video src="{{ asset('videos/buatkopi.mp4') }}" autoplay muted playsinline loop></video>
        <div class="hero-content container">
            <span class="kicker">Roasted • Crafted • Shared</span>
            <h1 class="display-3 fw-bold mt-2">Coffee House</h1>
            <p class="fs-5 mb-4">Perpaduan rasa yang jujur, dari tangan roaster ke cangkir Anda.</p>
            <div class="d-flex gap-2">
                <a href="#menu" class="btn btn-rust btn-pill">Lihat Menu</a>
                <a href="#about" class="btn btn-ghost btn-pill">Tentang Kami</a>
            </div>
            <small class="scroll-cue">Scroll untuk melihat</small>
        </div>
        <div class="divider-bottom" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 70" preserveAspectRatio="none">
                <path fill="#F3E3C2" d="M0,64 C240,8 420,8 720,48 C1020,88 1200,36 1440,8 L1440,140 L0,140 Z"></path>
            </svg>
        </div>
    </header>

    <!-- STRIP -->
    <section class="strip" aria-label="Our Beans">
        <div class="track" id="track">
            @php $drinks = ['Gn. Puntang', 'Temanggung', 'Timor Leste', 'Flores Bajawa', 'Toraja Sapan', 'Gunung Halu', 'Kerinci', 'Bali Kintamani']; @endphp
            @for ($dup = 0; $dup < 2; $dup++)
                @foreach ($drinks as $drink)
                    <div class="chip">
                        <img src="{{ asset('images/biji.JPG') }}" alt="Biji kopi - {{ $drink }}" loading="lazy">
                        <div class="meta">
                            <span class="name">{{ $drink }}</span>
                            <span class="price">IDR {{ 20 + (int) (crc32($drink) % 18) }}k</span>
                        </div>
                    </div>
                @endforeach
            @endfor
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 reveal">
                    <h2 class="fw-bold mb-3 title-underline">Tentang Kami</h2>
                    <p class="lead lead-muted">
                        Kami memilih biji terbaik, memanggangnya dengan presisi, lalu menyeduhnya dengan penuh
                        perhatian.
                        Semua untuk menghadirkan rasa yang konsisten dari <span class="text-teal">single origin</span>
                        hingga
                        <span class="text-rust">signature blend</span>.
                    </p>
                    <p class="text-secondary mb-0">Terinspirasi komunitas, kami percaya setiap cangkir mampu
                        menyambungkan
                        cerita—antara barista, petani, dan Anda.</p>
                </div>
                <div class="col-lg-6 reveal">
                    <img src="{{ asset('images/biji.JPG') }}" class="w-100 rounded-2xl shadow" alt="Biji kopi pilihan" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- MENU / PRODUCTS -->
    <section id="menu" class="section bg-sand">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <h2 class="fw-bold title-underline">Menu</h2>
                <p class="text-secondary mb-0">Daftar menu.</p>
            </div>

            <div class="row g-4">
                @for ($i = 1; $i <= 6; $i++)
                    @php
                        $title = "Signature Beans #{$i}";
                        $price = 80 + $i * 3;
                        $desc = "Origin single, roast medium, tasting notes: caramel, cocoa, hint of citrus. Cocok untuk espresso & manual brew.";
                      @endphp

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card-elev product-card position-relative">
                            <img src="{{ asset('images/biji.JPG') }}" class="w-100 product-img" alt="Produk {{ $i }}" loading="lazy">
                            <div class="p-3 p-md-4">
                                <h5 class="mb-1">{{ $title }}</h5>
                                <p class="text-secondary">{{ $desc }}</p>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="fw-semibold price-label">IDR {{ $price }}k</span>

                                    <!-- Tombol Detail: tooltip + buka modal (fade animasi Bootstrap) -->
                                    <button class="btn btn-sm btn-outline-dark rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#productModal{{ $i }}" aria-label="Lihat detail {{ $title }}">Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL QUICK VIEW (fade = animasi Bootstrap) -->
                    <div class="modal fade" id="productModal{{ $i }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow rounded-4">
                                <div class="modal-header bg-dark text-white rounded-top-4">
                                    <h5 class="modal-title">{{ $title }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <div class="row g-0">
                                        <div class="col-md-6">
                                            <img src="{{ asset('images/biji.JPG') }}"
                                                class="w-100 h-100 object-fit-cover rounded-start-4" alt="{{ $title }}" loading="lazy">
                                        </div>
                                        <div class="col-md-6 p-4">
                                            <p class="text-secondary mb-3">{{ $desc }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="h5 mb-0">IDR {{ $price }}k</span>
                                                <button class="btn btn-rust btn-pill">Tambah ke Keranjang</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light rounded-bottom-4">
                                    <button type="button" class="btn btn-outline-secondary btn-pill"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- MAP / LOKASI -->
    <section id="location" class="section">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 reveal">
                    <h2 class="fw-bold mb-3 title-underline">Lokasi / Maps</h2>
                    <p class="lead lead-muted mb-4">Klik tombol di bawah untuk membuka lokasi kami di Google Maps.</p>
                    <a href="https://maps.app.goo.gl/6JfGLKPEv9M2azMA8?g_st=aw" target="_blank" rel="noopener"
                        class="btn btn-rust btn-pill px-4 py-2">Buka di Google Maps</a>
                    <p class="text-secondary mt-3 mb-0" style="font-size:.95rem">
                        *Tautan akan membuka aplikasi/website Google Maps.
                    </p>
                </div>

                <div class="col-lg-6 reveal">
                    <div class="map-preview position-relative">
                        <div class="map-pin">
                            <svg viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path fill="#AF461F"
                                    d="M172.3 501.7C26.6 291.3 0 269.5 0 192 0 86 86 0 192 0s192 86 192 192c0 77.5-26.6 99.3-172.3 309.7a24 24 0 0 1-39.4 0zM192 272a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" />
                            </svg>
                        </div>
                        <a href="https://maps.app.goo.gl/6JfGLKPEv9M2azMA8?g_st=aw" target="_blank" rel="noopener"
                            class="stretched-link" aria-label="Buka lokasi di Google Maps"></a>
                        <span class="map-hint">Klik untuk membuka Maps</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AUTH CTA (Login / Register) -->
    <!-- diganti menjadi FORM REGISTRASI INLINE -->
    @guest('customer')
    <section id="register" class="section bg-sand">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-7 col-xl-6">
            <div class="glass-card p-4 p-md-5">
              <div class="text-center mb-4">
                <h2 class="fw-bold glass-title title-underline mb-2">Buat Akun</h2>
                <p class="text-secondary mb-0">Isi data berikut untuk mendaftar. Kolom yang diperlukan: nama lengkap, alamat, email, nomor telepon, dan kata sandi.</p>
              </div>

              <form action="{{ route('register.submit') }}" method="POST" class="reveal" novalidate>
                @csrf
                <div class="mb-3">
                  <label class="input-label" for="reg_nama">Nama Lengkap</label>
                  <input id="reg_nama" type="text" name="nama_lengkap" class="form-control glass-input @error('nama_lengkap') is-invalid @enderror" placeholder="Nama lengkap kamu" autocomplete="name" value="{{ old('nama_lengkap') }}" required>
                  @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                  <label class="input-label" for="reg_alamat">Alamat</label>
                  <input id="reg_alamat" type="text" name="alamat" class="form-control glass-input @error('alamat') is-invalid @enderror" placeholder="Alamat lengkap" autocomplete="street-address" value="{{ old('alamat') }}">
                  @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                  <label class="input-label" for="reg_email">Email</label>
                  <input id="reg_email" type="email" name="email" class="form-control glass-input @error('email') is-invalid @enderror" placeholder="nama@email.com" autocomplete="email" value="{{ old('email') }}" required>
                  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                  <label class="input-label" for="reg_telp">Nomor Telepon</label>
                  <input id="reg_telp" type="tel" name="no_telp" class="form-control glass-input @error('no_telp') is-invalid @enderror" placeholder="08xxxxxxxxxx" autocomplete="tel" pattern="[0-9 +]+" value="{{ old('no_telp') }}" required>
                  @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-1 pw-wrap">
                  <label class="input-label" for="reg_password">Kata Sandi</label>
                  <input id="reg_password" type="password" name="password" class="form-control glass-input @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" minlength="8" autocomplete="new-password" required>
                  <button type="button" class="pw-toggle" aria-label="Tampilkan/sembunyikan sandi" data-toggle-password="#reg_password">👁️</button>
                  @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="helper-text mb-3"><small>Minimal 8 karakter. Simpan sandi Anda dengan aman.</small></div>

                <button type="submit" class="btn btn-gradient w-100">Daftar</button>
              </form>

              <div class="text-center mt-3">
                <small class="text-muted">Sudah punya akun?
                  <button type="button" class="btn btn-link p-0 link-rust fw-semibold text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk di sini</button>
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endguest

    @guest('customer')
      @include('components.login-modal')
    @endguest

    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script>
        // Inisialisasi Tooltip Bootstrap agar atribut data-bs-toggle="tooltip" berfungsi
        const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));

        gsap.registerPlugin(ScrollTrigger);
        gsap.from('.kicker', { y: 20, opacity: 0, duration: .8, ease: 'power2.out' });
        gsap.from('.hero h1', { y: 24, opacity: 0, duration: .9, delay: .1, ease: 'power3.out' });
        gsap.from('.hero p', { y: 26, opacity: 0, duration: .9, delay: .18, ease: 'power3.out' });
        gsap.from('.hero .btn', { y: 18, opacity: 0, duration: .7, delay: .28, stagger: .08, ease: 'power2.out' });
        gsap.to('.hero video', { scale: 1.06, transformOrigin: 'center', scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: true } });
        gsap.utils.toArray('.reveal').forEach((el) => { gsap.to(el, { y: 0, opacity: 1, duration: .9, ease: 'power2.out', scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none reverse' } }); });
        gsap.utils.toArray('.card-elev').forEach((card) => { gsap.to(card, { y: 0, opacity: 1, duration: .75, ease: 'power3.out', scrollTrigger: { trigger: card, start: 'top 90%', toggleActions: 'play none none reverse' } }); });
        const track = document.getElementById('track');
        if (track) { track.addEventListener('mouseenter', () => track.style.animationPlayState = 'paused'); track.addEventListener('mouseleave', () => track.style.animationPlayState = 'running'); }

        document.addEventListener('DOMContentLoaded', () => {
            const usp = new URLSearchParams(location.search);
            if (usp.get('login') === '1') {
                const modalEl = document.getElementById('loginModal');
                if (modalEl) new bootstrap.Modal(modalEl).show();
            }
        });

        // Toggle show/hide password (fixed)
        document.querySelectorAll('[data-toggle-password]').forEach(btn => {
            btn.addEventListener('click', () => {
                const sel = btn.getAttribute('data-toggle-password');
                const input = document.querySelector(sel);
                if (!input) return;
                const isPwd = input.type === 'password';
                input.type = isPwd ? 'text' : 'password';
                btn.textContent = isPwd ? '🙈' : '👁️';
            });
        });
    </script>

    @if($errors->any() && !session('show_login'))
      <script>
        document.addEventListener('DOMContentLoaded', function(){
          const sec = document.getElementById('register');
          if (sec && typeof sec.scrollIntoView === 'function') {
            sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }
        });
      </script>
    @endif
</body>
</html>
