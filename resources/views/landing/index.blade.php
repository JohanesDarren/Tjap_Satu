<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coffee House | Specialty Roasters</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&family=Pinyon+Script&display=swap" rel="stylesheet">

    <style>
        :root {
            /* === GLOBAL THEME VARIABLES === */
            --bg-body: #F9F7F2;
            --color-primary: #2C3639; /* Dark Charcoal */
            --color-accent: #A27B5C; /* Roasted Bean/Bronze */
            --text-main: #2C3639;
            --text-muted: #6b7280;

            --font-display: 'Cinzel', serif;
            --font-body: 'DM Sans', sans-serif;
            --font-script: 'Pinyon Script', cursive;

            --ease-out: cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        /* --- GLOBAL RESET & HIDE SCROLLBAR --- */
        html {
            scroll-behavior: smooth;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE and Edge */
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: var(--font-body);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        body::-webkit-scrollbar {
            display: none;
        }

        h1, h2, h3, h4, h5 { font-family: var(--font-display); font-weight: 600; letter-spacing: -0.01em; }
        .font-script { font-family: var(--font-script); color: var(--color-accent); font-size: 2.5rem; }

        /* --- BUTTONS --- */
        .btn-pro {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--text-main);
            padding: 12px 32px;
            border-radius: 50px; /* Rounded Pill */
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            font-weight: 700;
            transition: all 0.4s var(--ease-out);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-pro:hover {
            background: var(--text-main);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .btn-accent {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
            color: #fff;
            padding: 12px 32px;
            border-radius: 50px;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-accent:hover {
            background-color: #8a664b;
            border-color: #8a664b;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(162, 123, 92, 0.3);
        }

        /* --- HERO SECTION --- */
        .hero-section {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow: hidden;
            margin-top: -80px;
            padding-top: 80px;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-bg video {
            width: 100%; height: 100%;
            object-fit: cover;
            filter: brightness(0.6) contrast(1.1);
            transform: scale(1.1);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
            padding: 2rem;
        }

        .hero-title {
            font-size: clamp(3rem, 8vw, 6rem);
            line-height: 1;
            margin-bottom: 1.5rem;
            text-shadow: 0 10px 30px rgba(0,0,0,0.3);
            opacity: 0; transform: translateY(30px);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }

        /* --- TICKER STRIP --- */
        .ticker-wrap {
            width: 100%;
            background: var(--color-primary);
            color: var(--bg-body);
            padding: 1rem 0;
            overflow: hidden;
            white-space: nowrap;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .ticker { display: inline-block; animation: marquee 40s linear infinite; }
        .ticker-item {
            display: inline-block; padding: 0 2rem;
            font-family: var(--font-display); font-size: 0.9rem;
            letter-spacing: 0.1em; text-transform: uppercase;
        }
        .ticker-item::after { content: "✦"; margin-left: 2rem; color: var(--color-accent); }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* --- SECTIONS --- */
        .section-padding { padding: 8rem 0; }

        .img-frame { position: relative; overflow: hidden; border-radius: 24px; }
        .img-frame img { transition: transform 1.5s var(--ease-out); border-radius: 24px; }
        .img-frame:hover img { transform: scale(1.05); }

        /* Product Card Pro */
        .product-card {
            border: none; background: transparent;
            margin-bottom: 3rem;
            transition: transform 0.3s ease;
        }
        .product-img-box {
            position: relative; background: #e5e5e5;
            aspect-ratio: 4/5; overflow: hidden;
            margin-bottom: 1.5rem;
            border-radius: 24px; /* Radius untuk gambar produk */
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .product-img-box img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s var(--ease-out);
        }
        .product-card:hover .product-img-box img { transform: scale(1.08); }

        .product-overlay {
            position: absolute; inset: 0;
            background: rgba(44, 54, 57, 0.4);
            opacity: 0; transition: opacity 0.3s ease;
            display: flex; align-items: center; justify-content: center;
        }
        .product-card:hover .product-overlay { opacity: 1; }

        .product-meta h5 { font-size: 1.25rem; margin-bottom: 0.25rem; }
        .product-meta .price { color: var(--color-accent); font-weight: 600; font-family: var(--font-body); }

        /* --- FORM STYLES --- */
        .form-clean input {
            background: transparent; border: none;
            border-bottom: 1px solid rgba(0,0,0,0.2);
            border-radius: 0; color: var(--text-main); padding: 1rem 0;
            transition: border-color 0.3s;
        }
        .form-clean input:focus {
            background: transparent; border-bottom-color: var(--color-accent);
            box-shadow: none; color: var(--text-main);
            outline: none;
        }
        .form-clean label {
            font-size: 0.75rem; text-transform: uppercase;
            letter-spacing: 0.1em; color: var(--text-muted);
            margin-top: 1rem;
        }

        /* Modal Polish with Radius */
        .modal-pro .modal-content { border-radius: 32px; border: none; background-color: var(--bg-body); overflow: hidden; }
        .modal-pro .btn-close { position: absolute; top: 1.5rem; right: 1.5rem; z-index: 10; }

        .separator { width: 1px; height: 60px; background: var(--color-accent); margin: 0 auto 2rem; }
        .text-accent { color: var(--color-accent) !important; }
    </style>
</head>
<body>

    <div style="position: relative; z-index: 1030;">
        @include('components.header')
    </div>

    <header class="hero-section">
        <div class="hero-bg">
            <video src="{{ asset('videos/buatkopi.mp4') }}" autoplay muted loop playsinline></video>
            <div style="position: absolute; inset:0; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6));"></div>
        </div>

        <div class="hero-content">
            <div class="separator bg-white mb-4"></div>
            <p class="hero-subtitle">Est. 2024 • Artisan Roastery</p>
            <h1 class="hero-title">Experience <br> <span class="fst-italic" style="font-family: var(--font-script); color: #fff; font-weight: 400;">The Art</span> of Coffee</h1>
            <div class="d-flex justify-content-center gap-3 mt-5">
                <a href="#menu" class="btn btn-pro text-white border-white">Explore Menu</a>
            </div>
        </div>

        <div style="position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); text-align: center;">
            <p class="small text-white text-uppercase ls-2 mb-2" style="font-size: 0.7rem;">Scroll</p>
            <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.5); margin: 0 auto;"></div>
        </div>
    </header>

    <div class="ticker-wrap">
        <div class="ticker">
            @php $origins = ['Gayo Highland', 'Toraja Sapan', 'Bali Kintamani', 'Flores Bajawa', 'Papua Wamena', 'Java Preanger', 'Lintong Ni Huta']; @endphp
            @for($i=0; $i<4; $i++)
                @foreach($origins as $origin)
                <div class="ticker-item">Single Origin: {{ $origin }}</div>
                @endforeach
            @endfor
        </div>
    </div>

    <section id="about" class="section-padding">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="img-frame reveal-img shadow-lg">
                        <img src="{{ asset('images/biji.JPG') }}" alt="Coffee Beans" class="w-100" style="min-height: 500px; object-fit: cover; filter: grayscale(20%);">
                        <div class="bg-white p-4 position-absolute bottom-0 end-0 m-4 shadow-sm d-none d-md-block" style="max-width: 250px; border-radius: 16px;">
                            <p class="mb-0 text-dark" style="font-family: var(--font-display);">"Setiap biji menceritakan kisah tanah tempatnya tumbuh."</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <span class="text-uppercase text-muted small ls-2 mb-3 d-block" style="letter-spacing: 2px;">Tentang Kami</span>
                    <h2 class="display-5 mb-4">Kami percaya kopi adalah <span class="fst-italic" style="font-family: var(--font-script); color: var(--color-accent);">ritual</span>, bukan sekadar rutinitas.</h2>
                    <p class="text-secondary mb-4" style="line-height: 1.8;">
                        Di Coffee House, kami mendedikasikan diri untuk mencari biji kopi terbaik dari seluruh nusantara.
                        Dipanggang dalam *small batches* untuk menjaga karakter unik setiap daerah.
                    </p>
                    <div class="d-flex gap-4 pt-3">
                        <div><h3 class="h2 mb-0">10+</h3><small class="text-uppercase text-muted">Origins</small></div>
                        <div><h3 class="h2 mb-0">100%</h3><small class="text-uppercase text-muted">Arabica</small></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="menu" class="section-padding bg-white" style="border-radius: 60px 60px 0 0;">
        <div class="container">
            <div class="text-center mb-5 pb-4">
                <span style="font-family: var(--font-script); font-size: 2.5rem; color: var(--text-muted);">Our Selection</span>
                <h2 class="display-4 mt-2">Seasonal Menu</h2>
            </div>

            @if(isset($products) && $products->count())
                <div class="row g-5">
                    @foreach ($products as $product)
                        @php
                            $img = $product->gambar ?? null;
                            $imgUrl = $img ? (preg_match('/^https?:\/\//', $img) ? $img : asset('storage/' . ltrim($img, '/'))) : asset('images/biji.JPG');
                            if($img && !preg_match('/^https?:\/\//', $img) && !file_exists(public_path('storage/'.ltrim($img, '/')))) {
                                $imgUrl = asset('uploads/' . ltrim($img, '/'));
                                if(!file_exists(public_path('uploads/'.ltrim($img, '/')))) $imgUrl = asset($img);
                            }
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <div class="product-card text-center">
                                <div class="product-img-box">
                                    <img src="{{ $imgUrl }}" alt="{{ $product->nama_produk }}">
                                    <div class="product-overlay">
                                        <button class="btn btn-pro text-white border-white btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#productModal{{ $product->id_product }}">
                                            Quick View
                                        </button>
                                    </div>
                                </div>
                                <div class="product-meta">
                                    <h5 style="font-family: var(--font-display);">{{ $product->nama_produk }}</h5>
                                    <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                        <span class="price">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade modal-pro" id="productModal{{ $product->id_product }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="row g-0">
                                        <div class="col-md-6">
                                            <img src="{{ $imgUrl }}" class="w-100 h-100 object-fit-cover" style="min-height: 400px;" alt="">
                                        </div>
                                        <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                                            <h3 class="mb-2">{{ $product->nama_produk }}</h3>
                                            <p class="fs-4 mb-4 fw-bold" style="color: var(--color-accent);">IDR {{ number_format($product->harga, 0, ',', '.') }}</p>
                                            <p class="text-muted mb-5">{{ $product->deskripsi ?? 'Deskripsi produk belum tersedia.' }}</p>

                                            @auth('customer')
                                                <form action="{{ route('cart.add', $product->id_product) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex gap-3">
                                                        <input type="number" name="jumlah" value="1" min="1" class="form-control rounded-pill text-center" style="width: 80px; border-color: var(--color-primary);">
                                                        <button type="submit" class="btn btn-pro w-100" style="background: var(--color-primary); color: #fff;">Add to Cart</button>
                                                    </div>
                                                </form>
                                            @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-pro w-100" style="background: var(--color-primary); color: #fff;">Login to Order</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('produk.menu') }}" class="btn btn-pro">View Full Menu</a>
                </div>
            @else
                <p class="text-center text-muted">Menu sedang disiapkan.</p>
            @endif
        </div>
    </section>

    <section id="location" class="section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 reveal">
                    <span class="text-uppercase text-muted small ls-2 mb-3 d-block" style="letter-spacing: 2px;">Kunjungi Kami</span>
                    <h2 class="display-5 mb-4">Lokasi & Jam Buka</h2>
                    <p class="text-secondary mb-4" style="line-height: 1.8;">
                        Rasakan suasana yang tenang ditemani aroma kopi segar. Kami buka setiap hari untuk menemani produktivitas maupun waktu santai Anda.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3 d-flex gap-3 align-items-center">
                            <div class="d-flex align-items-center justify-content-center rounded-circle border border-secondary p-2" style="width: 40px; height: 40px;">
                                <i class="bi bi-geo-alt-fill text-accent"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Alamat</h6>
                                <p class="text-muted small mb-0">Jl. Kopi Nikmat No. 123, Bandung, Jawa Barat</p>
                            </div>
                        </li>
                        <li class="d-flex gap-3 align-items-center">
                            <div class="d-flex align-items-center justify-content-center rounded-circle border border-secondary p-2" style="width: 40px; height: 40px;">
                                <i class="bi bi-clock-fill text-accent"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Jam Operasional</h6>
                                <p class="text-muted small mb-0">Senin - Minggu: 08.00 - 22.00 WIB</p>
                            </div>
                        </li>
                    </ul>
                    <a href="https://maps.google.com" target="_blank" class="btn btn-pro">Buka di Maps</a>
                </div>
                <div class="col-lg-7 reveal">
                    <div class="shadow-lg position-relative" style="border-radius: 32px; overflow: hidden; border: 4px solid #fff;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56347862!2d107.573117!3d-6.9034443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1646647970000!5m2!1sen!2sid"
                        width="100%" height="450" style="border:0; filter: grayscale(100%) invert(92%) contrast(83%);" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @guest('customer')
    <section id="register" class="section-padding position-relative" style="background-color: var(--color-primary); color: #fff; padding-bottom: 12rem; margin-bottom: -3rem; z-index: 1;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <span style="font-family: var(--font-script); color: var(--color-accent); font-size: 2rem;">Membership</span>
                    <h2 class="display-5 mb-5 mt-2">Bergabung Bersama Kami</h2>
                    <p class="text-white-50 mb-5 mx-auto" style="max-width: 500px;">Dapatkan akses eksklusif dan kemudahan pemesanan.</p>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('register.submit') }}" method="POST" class="form-clean">
                        @csrf
                        <div class="row g-4">
                            <style>
                                /* Fix UI: Paksa text jadi putih dan background transparan */
                                .form-dark input {
                                    border-bottom-color: rgba(255,255,255,0.3) !important;
                                    color: #fff !important;
                                    background: transparent !important;
                                }
                                .form-dark input:focus {
                                    border-bottom-color: var(--color-accent) !important;
                                    box-shadow: none !important;
                                    outline: none !important;
                                }
                                .form-dark label {
                                    color: rgba(255,255,255,0.7) !important;
                                    font-size: 0.8rem;
                                    letter-spacing: 1px;
                                    text-transform: uppercase;
                                }
                                .form-dark input:-webkit-autofill,
                                .form-dark input:-webkit-autofill:hover,
                                .form-dark input:-webkit-autofill:focus {
                                    -webkit-text-fill-color: #fff !important;
                                    -webkit-box-shadow: 0 0 0px 1000px var(--color-primary) inset !important;
                                    transition: background-color 5000s ease-in-out 0s;
                                }
                            </style>

                            <div class="col-md-6 form-dark">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="w-100" required value="{{ old('nama_lengkap') }}">
                                @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-dark">
                                <label>No. Telepon</label>
                                <input type="tel" name="no_telp" class="w-100" required value="{{ old('no_telp') }}"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('no_telp') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 form-dark">
                                <label>Alamat Lengkap</label>
                                <input type="text" name="alamat" class="w-100" required value="{{ old('alamat') }}">
                                @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 form-dark">
                                <label>Email</label>
                                <input type="email" name="email" class="w-100" required value="{{ old('email') }}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 form-dark position-relative">
                                <label>Password</label>
                                <input type="password" name="password" id="reg_password" class="w-100" required>
                                <span onclick="toggleRegPassword()" style="position: absolute; right: 0; bottom: 10px; cursor: pointer; color: rgba(255,255,255,0.6);">
                                    <i class="bi bi-eye" id="icon_reg"></i>
                                </span>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 text-center mt-5">
                                <button type="submit" class="btn btn-accent px-5 py-3">Buat Akun</button>
                            </div>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <small class="text-white-50">Sudah punya akun? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="text-white text-decoration-underline">Masuk disini</a></small>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function toggleRegPassword() {
                var x = document.getElementById("reg_password");
                var icon = document.getElementById("icon_reg");
                if (x.type === "password") {
                    x.type = "text";
                    icon.classList.remove("bi-eye");
                    icon.classList.add("bi-eye-slash");
                } else {
                    x.type = "password";
                    icon.classList.remove("bi-eye-slash");
                    icon.classList.add("bi-eye");
                }
            }
        </script>
    </section>
    @endguest

    @include('components.footer')

    @guest('customer')
        @include('components.login-modal')
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <script>
        gsap.registerPlugin(ScrollTrigger);
        gsap.to('.hero-title', { y: 0, opacity: 1, duration: 1.2, ease: 'power3.out', delay: 0.2 });
        gsap.from('.hero-subtitle', { y: 20, opacity: 0, duration: 1, ease: 'power3.out', delay: 0.5 });
        gsap.utils.toArray('.reveal-img, .reveal').forEach(container => {
            gsap.fromTo(container,
                { y: 30, opacity: 0 },
                { y: 0, opacity: 1, duration: 1, ease: 'power3.out', scrollTrigger: { trigger: container, start: "top 85%" } }
            );
        });
        gsap.utils.toArray('h2, .product-card').forEach(el => {
            gsap.from(el, {
                y: 30, opacity: 0, duration: 0.8, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 85%' }
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            const usp = new URLSearchParams(location.search);
            if (usp.get('login') === '1') {
                const modalEl = document.getElementById('loginModal');
                if (modalEl) new bootstrap.Modal(modalEl).show();
            }
        });
    </script>
</body>
</html>
