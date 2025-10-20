{{-- resources/views/landing.blade.php --}}
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coffee Landing • Palette</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">

    <style>
        /* ===== Color Palette (dipakai di seluruh halaman) ===== */
        :root {
            --bg: #F3E3C2;
            /* sand */
            --coffee: #55351D;
            /* deep brown */
            --ink: #2E373D;
            /* dark slate */
            --rust: #AF461F;
            /* rusty red (CTA) */
            --teal: #325B56;
            /* deep teal (accent) */

            --surface: #fff;
            --shadow: 0 20px 50px rgba(46, 55, 61, .18);
            --radius-xl: 24px;
            --radius-2xl: 1.6rem;
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: Poppins, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: "Playfair Display", serif;
            color: var(--coffee);
            letter-spacing: .02em;
        }

        /* ===== HERO (video) ===== */
        .hero {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            isolation: isolate;
        }

        .hero video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: contrast(1.06) saturate(1.05) brightness(.95);
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            /* overlay hitam cinematic */
            background: linear-gradient(to top, rgba(0, 0, 0, .55) 0%, rgba(0, 0, 0, .25) 60%, rgba(0, 0, 0, 0) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding: 7rem 1rem 9rem;
            text-align: center;
            color: #fff;
            text-shadow: 0 2px 20px rgba(0, 0, 0, .5);
        }

        .kicker {
            text-transform: uppercase;
            letter-spacing: .28em;
            font-weight: 600;
            opacity: .9;
        }

        .btn-pill {
            border-radius: 999px;
            padding: .9rem 1.6rem;
            font-weight: 600;
            letter-spacing: .02em;
            box-shadow: 0 10px 24px rgba(175, 70, 31, .25);
        }

        .btn-rust {
            background: var(--rust);
            color: #fff;
            border: none;
        }

        .btn-rust:hover {
            filter: brightness(.95) saturate(1.03);
        }

        .scroll-cue {
            position: absolute;
            bottom: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            opacity: .85;
            font-size: .95rem;
        }

        /* ===== Divider wave ===== */
        .divider-bottom {
            line-height: 0;
        }

        .divider-bottom svg {
            display: block;
            width: 100%;
            height: 70px;
        }

        /* ===== PARALLAX STRIP ===== */
        .parallax {
            position: relative;
            height: 64vh;
            display: grid;
            place-items: center;
            overflow: hidden;
            background: url('{{ asset('images/biji.JPG') }}') center/cover no-repeat fixed;
        }

        .parallax .veil {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(50, 91, 86, .45), rgba(50, 91, 86, .25), rgba(243, 227, 194, .9));
            mix-blend: multiply;
        }

        .parallax h2 {
            position: relative;
            z-index: 2;
            color: #fff;
            font-weight: 800;
            text-shadow: 0 18px 40px rgba(0, 0, 0, .35);
            font-size: clamp(2.6rem, 8vw, 5rem);
            letter-spacing: .06em;
        }

        /* ===== INFINITE CAROUSEL (strip) ===== */
        .strip {
            --gap: 26px;
            --h: 190px;
            --w: 260px;
            --speed: 28s;
            position: relative;
            overflow: hidden;
            padding-block: 26px;
            background: linear-gradient(180deg, #f8edd0, var(--bg));
            mask-image: linear-gradient(to right, transparent, #000 8%, #000 92%, transparent);
            border-top: 1px solid rgba(46, 55, 61, .06);
            border-bottom: 1px solid rgba(46, 55, 61, .06);
        }

        .track {
            display: flex;
            gap: var(--gap);
            width: max-content;
            will-change: transform;
            animation: marquee var(--speed) linear infinite;
        }

        @keyframes marquee {
            to {
                transform: translateX(calc(-50% - var(--gap)));
            }
        }

        .chip {
            width: var(--w);
            height: var(--h);
            flex: 0 0 auto;
            border-radius: 18px;
            overflow: hidden;
            background: var(--surface);
            box-shadow: var(--shadow);
            border: 1px solid rgba(46, 55, 61, .06);
        }

        .chip img {
            width: 100%;
            height: 60%;
            object-fit: cover;
            display: block;
        }

        .chip .meta {
            padding: .75rem .9rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chip .name {
            color: var(--coffee);
            font-weight: 700;
        }

        .chip .price {
            background: var(--teal);
            color: #fff;
            padding: .25rem .6rem;
            border-radius: 999px;
            font-size: .85rem;
        }

        /* ===== Sections & Cards ===== */
        section.section {
            padding: 84px 0;
        }

        .lead-muted {
            color: #5a676c;
            opacity: .9;
        }

        .rounded-2xl {
            border-radius: var(--radius-2xl);
        }

        .card-elev {
            background: var(--surface);
            border: none;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            transform: translateY(38px);
            opacity: 0;
            transition: transform .45s ease, box-shadow .28s ease, filter .28s ease;
            border: 1px solid rgba(46, 55, 61, .06);
        }

        .card-elev:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 70px rgba(46, 55, 61, .24);
            filter: saturate(1.04) contrast(1.02);
        }

        .card-elev img {
            height: 230px;
            object-fit: cover;
        }

        /* Animasi halus ala Bootstrap untuk card & tombol */
.card-elev { transition: transform .3s ease, box-shadow .3s ease, filter .3s ease; }
.card-elev:hover { transform: translateY(-6px); box-shadow: 0 28px 70px rgba(46,55,61,.24); filter: saturate(1.04) contrast(1.02); }

.card-elev .btn-outline-dark { transition: transform .2s ease, box-shadow .2s ease; }
.card-elev .btn-outline-dark:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,.16); }

        /* ===== Maps/Lokasi preview ===== */
        .map-preview {
            position: relative;
            height: 380px;
            border-radius: var(--radius-2xl);
            background:
                radial-gradient(120px 120px at 20% 30%, rgba(50, 91, 86, .20), transparent 60%),
                radial-gradient(160px 120px at 70% 60%, rgba(175, 70, 31, .16), transparent 60%),
                linear-gradient(180deg, #f7ead0, var(--bg));
            box-shadow: var(--shadow);
            border: 1px solid rgba(46, 55, 61, .08);
            overflow: hidden;
        }

        .map-pin {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
        }

        .map-pin svg {
            width: 82px;
            height: 82px;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, .25));
        }

        .map-hint {
            position: absolute;
            bottom: 14px;
            right: 16px;
            background: #fff;
            color: var(--ink);
            padding: .45rem .75rem;
            border-radius: 999px;
            font-size: .9rem;
            box-shadow: var(--shadow);
        }

        /* ===== Reveal & titles ===== */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
        }

        .title-underline {
            position: relative;
            display: inline-block;
        }

        .title-underline::after {
            content: "";
            position: absolute;
            left: 6px;
            right: -6px;
            bottom: -8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--rust), var(--teal));
            opacity: .25;
        }

        /* ===== Utilities dipakai di markup ===== */
        .text-teal {
            color: var(--teal);
        }

        .bg-sand {
            background: var(--bg);
        }

        .text-rust {
            color: var(--rust);
        }
    </style>
</head>

<body>
    @extends('layouts.main')

    <!-- ============= HERO (Video buatkopi.mp4) ============= -->
    <header class="hero">
        <video src="{{ asset('videos/buatkopi.mp4') }}" autoplay muted playsinline loop></video>
        <div class="hero-content container">
            <span class="kicker">Roasted • Crafted • Shared</span>
            <h1 class="display-3 fw-bold mt-2">Coffee House</h1>
            <p class="fs-5 mb-4">Perpaduan rasa yang jujur, dari tangan roaster ke cangkir Anda.</p>
            <small class="scroll-cue">Scroll untuk melihat</small>
        </div>
        <div class="divider-bottom" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 70" preserveAspectRatio="none">
                <path fill="#F3E3C2" d="M0,64 C240,8 420,8 720,48 C1020,88 1200,36 1440,8 L1440,140 L0,140 Z"></path>
            </svg>
        </div>
    </header>

    <!-- ============= PARALLAX "Coffee Shop" ============= -->
    <section class="parallax">
        <div class="veil"></div>
        <h2 class="fw-bold text-uppercase">Coffee&nbsp;Shop</h2>
    </section>

    <!-- ============= INFINITE CAROUSEL (strip) ============= -->
    <section class="strip" aria-label="Our Beans">
        <div class="track" id="track">
            @php $drinks = ['Espresso', 'Latte', 'Cappuccino', 'Americano', 'Mocha', 'Caramel Macchiato', 'Flat White', 'Affogato']; @endphp
            @for ($dup = 0; $dup < 2; $dup++)
                @foreach ($drinks as $drink)
                    <div class="chip">
                        <img src="{{ asset('images/biji.JPG') }}" alt="Biji kopi - {{ $drink }}">
                        <div class="meta">
                            <span class="name">{{ $drink }}</span>
                            <span class="price">IDR {{ 20 + (int) (crc32($drink) % 18) }}k</span>
                        </div>
                    </div>
                @endforeach
            @endfor
        </div>
    </section>

    <!-- ============= ABOUT ============= -->
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
                    <img src="{{ asset('images/biji.JPG') }}" class="w-100 rounded-2xl shadow" alt="Biji kopi pilihan">
                </div>
            </div>
        </div>
    </section>

    <!-- ============= PRODUCT CARDS (dengan animasi Bootstrap) ============= -->
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
            $desc  = "Origin single, roast medium, tasting notes: caramel, cocoa, hint of citrus. Cocok untuk espresso & manual brew.";
          @endphp
  
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card-elev product-card position-relative">
              <img src="{{ asset('images/biji.JPG') }}" class="w-100" alt="Produk {{ $i }}">
              <div class="p-3 p-md-4">
                <h5 class="mb-1">{{ $title }}</h5>
                <p class="text-secondary">{{ $desc }}</p>
  
                <div class="d-flex justify-content-between align-items-center mt-2">
                  <span class="fw-semibold">IDR {{ $price }}k</span>
  
                  <!-- Tombol Detail: tooltip + buka modal (fade animasi Bootstrap) -->
                  <button
                    class="btn btn-sm btn-outline-dark rounded-pill"
                    data-bs-toggle="tooltip"
                    data-bs-title="Lihat detail produk"
                    data-bs-placement="top"
                    data-bs-custom-class="tooltip-dark"
                    data-bs-trigger="hover focus"
                    data-bs-offset="0,8"
                    data-bs-container="body"
                    data-bs-dismiss="tooltip"
                    data-bs-target="#productModal{{ $i }}"
                    data-bs-toggle="modal"
                  >
                    Detail
                  </button>
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
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                  <div class="row g-0">
                    <div class="col-md-6">
                      <img src="{{ asset('images/biji.JPG') }}" class="w-100 h-100 object-fit-cover rounded-start-4" alt="{{ $title }}">
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
                  <button type="button" class="btn btn-outline-secondary btn-pill" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
        @endfor
      </div>
    </div>
  </section>
  

    <!-- ============= MAPS / LOKASI ============= -->
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

    <!-- Bootstrap + GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script>
        gsap.registerPlugin(ScrollTrigger);

        // HERO text entrance
        gsap.from(".kicker", { y: 20, opacity: 0, duration: .8, ease: "power2.out" });
        gsap.from(".hero h1", { y: 24, opacity: 0, duration: .9, delay: .1, ease: "power3.out" });
        gsap.from(".hero p", { y: 26, opacity: 0, duration: .9, delay: .18, ease: "power3.out" });

        // gentle parallax on hero video
        gsap.to('.hero video', {
            scale: 1.06, transformOrigin: "center",
            scrollTrigger: { trigger: '.hero', start: "top top", end: "bottom top", scrub: true }
        });

        // Parallax headline float
        gsap.to('.parallax h2', {
            yPercent: -20, ease: "none",
            scrollTrigger: { trigger: '.parallax', start: "top bottom", end: "bottom top", scrub: true }
        });

        // Reveal on scroll
        gsap.utils.toArray('.reveal').forEach((el) => {
            gsap.to(el, {
                y: 0, opacity: 1, duration: .9, ease: "power2.out",
                scrollTrigger: { trigger: el, start: "top 85%", toggleActions: "play none none reverse" }
            });
        });

        // Elevation cards rise on scroll
        gsap.utils.toArray('.card-elev').forEach((card) => {
            gsap.to(card, {
                y: 0, opacity: 1, duration: .75, ease: "power3.out",
                scrollTrigger: { trigger: card, start: "top 90%", toggleActions: "play none none reverse" }
            });
        });

        // Pause/resume marquee on hover
        const track = document.getElementById('track');
        if (track) {
            track.addEventListener('mouseenter', () => track.style.animationPlayState = 'paused');
            track.addEventListener('mouseleave', () => track.style.animationPlayState = 'running');
        }
        
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
  });
    </script>
</body>

</html>