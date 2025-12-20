<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coffee House | Specialty Roasters</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Fonts --}}
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

        /* --- GLOBAL RESET --- */
        html { scroll-behavior: smooth; scrollbar-width: none; }
        body { background-color: var(--bg-body); color: var(--text-main); font-family: var(--font-body); overflow-x: hidden; }
        body::-webkit-scrollbar { display: none; }
        h1, h2, h3, h4, h5 { font-family: var(--font-display); font-weight: 600; letter-spacing: -0.01em; }
        .font-script { font-family: var(--font-script); color: var(--color-accent); font-size: 2.5rem; }

        /* --- BUTTONS --- */
        .btn-pro {
            background: transparent; color: var(--text-main); border: 1px solid var(--text-main);
            padding: 12px 32px; border-radius: 50px; text-transform: uppercase; font-size: 0.75rem;
            letter-spacing: 0.15em; font-weight: 700; transition: all 0.4s var(--ease-out);
            position: relative; overflow: hidden; z-index: 1;
        }
        .btn-pro:hover { background: var(--text-main); color: #fff; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        .btn-accent {
            background-color: var(--color-accent); border-color: var(--color-accent); color: #fff;
            padding: 12px 32px; border-radius: 50px; text-transform: uppercase; font-size: 0.75rem;
            letter-spacing: 0.15em; font-weight: 700; transition: all 0.3s ease;
        }
        .btn-accent:hover { background-color: #8a664b; border-color: #8a664b; color: #fff; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(162, 123, 92, 0.3); }

        /* --- HERO SECTION --- */
        .hero-section { height: 100vh; position: relative; display: flex; align-items: center; justify-content: center; color: #fff; overflow: hidden; margin-top: -80px; padding-top: 80px; }
        .hero-bg { position: absolute; inset: 0; z-index: 0; }
        .hero-bg video { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6) contrast(1.1); transform: scale(1.1); }
        .hero-content { position: relative; z-index: 2; text-align: center; max-width: 800px; padding: 2rem; }
        .hero-title { font-size: clamp(3rem, 8vw, 6rem); line-height: 1; margin-bottom: 1.5rem; text-shadow: 0 10px 30px rgba(0,0,0,0.3); opacity: 0; transform: translateY(30px); }
        .hero-subtitle { font-size: 1.1rem; letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 2.5rem; opacity: 0.9; }

        /* --- TICKER STRIP --- */
        .ticker-wrap { width: 100%; background: var(--color-primary); color: var(--bg-body); padding: 1rem 0; overflow: hidden; white-space: nowrap; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .ticker { display: inline-block; animation: marquee 60s linear infinite; }
        .ticker-item { display: inline-block; padding: 0 2rem; font-family: var(--font-display); font-size: 0.9rem; letter-spacing: 0.1em; text-transform: uppercase; }
        .ticker-item::after { content: "✦"; margin-left: 2rem; color: var(--color-accent); }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* --- SECTIONS --- */
        .section-padding { padding: 8rem 0; }
        .img-frame { position: relative; overflow: hidden; border-radius: 24px; }
        .img-frame img { transition: transform 1.5s var(--ease-out); border-radius: 24px; }
        .img-frame:hover img { transform: scale(1.05); }

        /* Product Card */
        .product-card { border: none; background: transparent; margin-bottom: 3rem; transition: transform 0.3s ease; }
        .product-img-box { position: relative; background: #e5e5e5; aspect-ratio: 4/5; overflow: hidden; margin-bottom: 1.5rem; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .product-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s var(--ease-out); }
        .product-card:hover .product-img-box img { transform: scale(1.08); }
        .product-overlay { position: absolute; inset: 0; background: rgba(44, 54, 57, 0.4); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: center; justify-content: center; }
        .product-card:hover .product-overlay { opacity: 1; }
        .product-meta h5 { font-size: 1.25rem; margin-bottom: 0.25rem; }
        .product-meta .price { color: var(--color-accent); font-weight: 600; font-family: var(--font-body); }

        /* Modal */
        .modal-pro .modal-content { border-radius: 32px; border: none; background-color: var(--bg-body); overflow: hidden; }
        .separator { width: 1px; height: 60px; background: var(--color-accent); margin: 0 auto 2rem; }
        .text-accent { color: var(--color-accent) !important; }
    </style>
</head>
<body>

    <div style="position: relative; z-index: 1030;">
        @include('components.header')
    </div>

    {{-- HERO --}}
    <header class="hero-section">
        <div class="hero-bg">
            <video src="{{ asset('videos/buatkopi.mp4') }}" autoplay muted loop playsinline></video>
            <div style="position: absolute; inset:0; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6));"></div>
        </div>
        <div class="hero-content">
            <div class="separator bg-white mb-4"></div>
            <p class="hero-subtitle">Est. 2024 • Artisan Roastery</p>
            <h1 class="hero-title">Experience <br> <span class="fst-italic" style="font-family: var(--font-script); color: #AF461F; font-weight: 400;">The Art</span> of Coffee</h1>
            <div class="d-flex justify-content-center gap-3 mt-5">
                <a href="#menu" class="btn btn-pro text-white border-white">Explore Menu</a>
            </div>
        </div>
        <div style="position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); text-align: center;">
            <p class="small text-white text-uppercase ls-2 mb-2" style="font-size: 0.7rem;">Scroll</p>
            <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.5); margin: 0 auto;"></div>
        </div>
    </header>

    {{-- TICKER --}}
    <div class="ticker-wrap">
        <div class="ticker">
            @if(isset($stripProducts) && count($stripProducts) > 0)
                @for($i=0; $i<4; $i++)
                    @foreach($stripProducts as $item)
                        <div class="ticker-item">{{ $item->nama_produk }}</div>
                    @endforeach
                @endfor
            @else
                 <div class="ticker-item">FRESH ROASTED COFFEE • PREMIUM ARABICA • SINGLE ORIGIN • </div>
                 <div class="ticker-item">FRESH ROASTED COFFEE • PREMIUM ARABICA • SINGLE ORIGIN • </div>
            @endif
        </div>
    </div>

    {{-- ABOUT SECTION --}}
    <section id="about" class="section-padding position-relative overflow-hidden" style="background: linear-gradient(to bottom, var(--bg-body), #f0ece6);">
        <div style="position: absolute; top: -20%; right: -10%; width: 400px; height: 400px; background: var(--color-accent); opacity: 0.03; border-radius: 50%; filter: blur(100px); z-index: 0;"></div>

        <div class="container position-relative" style="z-index: 1;">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="img-frame reveal-img shadow-lg position-relative rounded-5 overflow-hidden">
                        <img src="{{ asset('images/biji.JPG') }}" alt="Coffee Beans" class="w-100" style="min-height: 500px; object-fit: cover; filter: grayscale(10%) contrast(1.1) brightness(0.9);">
                        <div class="position-absolute bottom-0 start-0 w-100 p-4"
                                style="background: rgba(44, 54, 57, 0.6); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border-top: 1px solid rgba(255,255,255,0.1);">
                                <div>
                                    <p class="mb-3 fst-italic text-white fw-light lh-base" style="font-family: var(--font-display); font-size: 1.1rem; letter-spacing: 0.5px;">
                                        "Setiap biji adalah warisan; menceritakan kisah tanah kelahirannya dengan jujur dalam setiap tegukan."
                                    </p>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="height: 1px; width: 20px; background: var(--color-accent); opacity: 0.7;"></div>
                                        <small class="text-uppercase ls-2 fw-bold text-white-50" style="font-size: 0.65rem;">Our Philosophy</small>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 ps-lg-5">
                    <span class="text-uppercase text-accent small ls-2 mb-3 d-block fw-bold reveal">Tentang Kami</span>
                    <h2 class="display-5 mb-4 reveal" style="color: var(--color-primary);">Kami percaya kopi adalah <span class="fst-italic font-script" style="font-weight: 400; font-size: 3rem; color: #AF461F;">ritual</span>, bukan sekadar rutinitas.</h2>
                    <p class="text-muted mb-5 reveal lead" style="line-height: 1.9; font-size: 1.05rem;">
                        Di Coffee House, kami mendedikasikan diri untuk mengurasi biji kopi terbaik dari dataran tinggi Nusantara.
                        Dipanggang dalam <i>small batches</i> dengan presisi tinggi untuk menjaga karakter unik dan kekayaan rasa setiap daerah.
                    </p>
                    <div class="d-flex gap-5 pt-2 reveal align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-accent-subtle p-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: rgba(162, 123, 92, 0.1);">
                                <i class="bi bi-globe-asia-australia fs-4 text-accent"></i>
                            </div>
                            <div>
                                <h3 class="display-5 fw-bold mb-0" style="color: var(--color-primary); font-family: var(--font-body);">
                                    <span class="scramble-num" data-final="10">0</span><span class="text-accent fs-5 ms-1">+</span>
                                </h3>
                                <small class="text-uppercase text-muted fw-bold ls-1" style="font-size: 0.75rem;">Single Origins</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-accent-subtle p-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: rgba(162, 123, 92, 0.1);">
                                <i class="bi bi-award fs-4 text-accent"></i>
                            </div>
                            <div>
                                <h3 class="display-5 fw-bold mb-0" style="color: var(--color-primary); font-family: var(--font-body);">
                                    <span class="scramble-num" data-final="100">0</span><span class="text-accent fs-5 ms-1">%</span>
                                </h3>
                                <small class="text-uppercase text-muted fw-bold ls-1" style="font-size: 0.75rem;">Arabica Beans</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MENU SECTION --}}
    <section id="menu" class="section-padding bg-white" style="border-radius: 60px 60px 0 0;">
        <div class="container">
            <div class="text-center mb-5 pb-4 reveal">
                <span style="font-family: var(--font-script); font-size: 2.5rem; color: #AF461F;">Our Selection</span>
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
                        {{-- MODAL PRODUK --}}
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

    {{-- LOCATION --}}
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

    {{-- REGISTER SECTION (FIXED FORM) --}}
    @guest('customer')
    <section id="register" class="section-padding position-relative" style="background-color: var(--color-primary); color: #fff; padding-bottom: 12rem; margin-bottom: -3rem; z-index: 1;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center reveal">
                    <span style="font-family: var(--font-script); color: var(--color-accent); font-size: 2rem;">Membership</span>
                    <h2 class="display-5 mb-5 mt-2">Bergabung Bersama Kami</h2>
                    <p class="text-white-50 mb-5 mx-auto" style="max-width: 500px;">Dapatkan akses eksklusif dan kemudahan pemesanan.</p>
                </div>
                <div class="col-lg-8 reveal">
                    <form action="{{ route('register.submit') }}" method="POST" class="form-clean">
                        @csrf
                        {{-- STYLE FIX: Autofill browser & Input Colors --}}
                        <style>
                            .form-dark input {
                                border-bottom: 1px solid rgba(255,255,255,0.2) !important;
                                background: transparent !important;
                                color: #fff !important;
                                border-radius: 0;
                                padding: 0.8rem 0;
                            }
                            .form-dark input:focus {
                                border-bottom-color: var(--color-accent) !important;
                                box-shadow: none !important;
                                outline: none !important;
                            }
                            .form-dark label {
                                color: rgba(255,255,255,0.6) !important;
                                font-size: 0.8rem;
                                text-transform: uppercase;
                                letter-spacing: 1px;
                                margin-bottom: 0;
                            }
                            /* Paksa background autofill jadi gelap */
                            .form-dark input:-webkit-autofill,
                            .form-dark input:-webkit-autofill:hover,
                            .form-dark input:-webkit-autofill:focus {
                                -webkit-text-fill-color: #fff !important;
                                -webkit-box-shadow: 0 0 0px 1000px var(--color-primary) inset !important;
                                transition: background-color 5000s ease-in-out 0s;
                            }
                        </style>

                        <div class="row g-4">
                            <div class="col-md-6 form-dark">
                                <label for="reg_nama">Nama Lengkap</label>
                                <input type="text" id="reg_nama" name="nama_lengkap" class="w-100 border-0" required value="{{ old('nama_lengkap') }}">
                                @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-dark">
                                <label for="reg_telp">No. Telepon</label>
                                <input type="tel" id="reg_telp" name="no_telp" class="w-100 border-0" required value="{{ old('no_telp') }}"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('no_telp') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-dark">
                                <label for="reg_email">Email Address</label>
                                <input type="email" id="reg_email" name="email" class="w-100 border-0" required value="{{ old('email') }}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-dark position-relative">
                                <label for="reg_password">Password</label>
                                <div class="position-relative">
                                    <input type="password" id="reg_password" name="password" class="w-100 border-0" required style="padding-right: 2rem;">
                                    <span onclick="toggleRegPassword()" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); cursor: pointer; color: rgba(255,255,255,0.6); z-index: 10;">
                                        <i class="bi bi-eye" id="icon_reg"></i>
                                    </span>
                                </div>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 form-dark">
                                <label for="reg_alamat">Alamat Lengkap</label>
                                <input type="text" id="reg_alamat" name="alamat" class="w-100 border-0" required value="{{ old('alamat') }}" placeholder="Jalan, No. Rumah, Kota...">
                                @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 text-center mt-5">
                                <button type="submit" class="btn btn-accent px-5 py-3">Buat Akun Member</button>
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

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        // Hero Animations
        gsap.to('.hero-title', { y: 0, opacity: 1, duration: 1.2, ease: 'power3.out', delay: 0.2 });
        gsap.from('.hero-subtitle', { y: 20, opacity: 0, duration: 1, ease: 'power3.out', delay: 0.5 });

        // Reveal Animations (ScrollTrigger)
        gsap.utils.toArray('.reveal-img, .reveal').forEach(container => {
            gsap.fromTo(container,
                { y: 30, opacity: 0 },
                { y: 0, opacity: 1, duration: 1, ease: 'power3.out', scrollTrigger: { trigger: container, start: "top 85%" } }
            );
        });

        // Product Card Stagger
        gsap.utils.toArray('.product-card').forEach(el => {
            gsap.from(el, {
                y: 30, opacity: 0, duration: 0.8, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 85%' }
            });
        });

        // --- ANIMASI SCRAMBLE NUMBER ---
        function playScrambleText(element) {
            const finalValue = parseInt(element.getAttribute('data-final'));
            const duration = 1500;
            let startTime = null;
            function update(currentTime) {
                if (!startTime) startTime = currentTime;
                const progress = currentTime - startTime;
                if (progress < duration) {
                    element.innerText = Math.floor(Math.random() * 99);
                    requestAnimationFrame(update);
                } else {
                    element.innerText = finalValue;
                }
            }
            requestAnimationFrame(update);
        }

        ScrollTrigger.create({
            trigger: "#about",
            start: "top 75%",
            once: true,
            onEnter: () => {
                document.querySelectorAll('.scramble-num').forEach(el => {
                    playScrambleText(el);
                });
            }
        });

        // Auto Show Login Modal
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
