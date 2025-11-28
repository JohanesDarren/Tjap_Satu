<footer class="text-white position-relative footer-gradient">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row g-4 align-items-start m-3">
            <!-- Kolom 1: Logo & Deskripsi -->
            <div class="col-md-5">
                <h3 class="fw-bold text-uppercase text-brand">TOKOKOPITJAP1</h3>
                <p class="mt-3 footer-desc">
                    TokoKopiTjap1 hadir sebagai gerakan untuk mengenalkan dan mengangkat potensi biji kopi lokal Nusantara. Kami percaya bahwa setiap biji kopi memiliki cerita — tentang tanah tempat ia tumbuh, tentang tangan yang merawatnya, dan tentang semangat masyarakat yang menjaganya. Melalui kolaborasi dengan petani dan pelaku usaha kecil, kami berkomitmen menghadirkan biji kopi berkualitas dengan prinsip keberlanjutan dan nilai kemanusiaan. Dari ladang hingga ke tangan penikmatnya, kami ingin menjaga cita rasa dan makna di setiap prosesnya.
                    Inilah semangat kami dalam
                    <span class="text-brand">#KopiRakyatNusantara</span> — merayakan kerja keras, rasa, dan kebanggaan atas hasil bumi sendiri.
                </p>

                <!-- Kontak -->
                <ul class="list-unstyled mt-4 footer-contacts">
                    <li class="mb-2">
                        <i class="bi bi-telephone-fill text-warning me-2"></i> 0878-2169-9178
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope-fill text-warning me-2"></i>
                        <a href="mailto:tokokopitjap1@gmail.com" class="text-decoration-none link-light">tokokopitjap1@gmail.com</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-instagram text-warning me-2"></i>
                        <a href="https://www.instagram.com/kopitjapsatu/" target="_blank" rel="noopener noreferrer" class="text-decoration-none link-light">
                            @kopitjapsatu
                        </a>
                    </li>
                    <li>
                        <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                        Jl. lorem ipsum, Bandung
                    </li>
                </ul>
            </div>

            <!-- Kolom 2: Order -->
            <div class="col-md-2">
                <h6 class="fw-bold mb-3 fs-5 text-uppercase text-accent">Order</h6>
                <ul class="list-unstyled footer-links fs-6">
                    <li><a href="{{ route('home') }}#menu" class="link-fade"><i class="bi bi-cup-hot me-2 text-warning"></i>Lihat Menu</a></li>
                    <li><a href="#" class="link-fade"><i class="bi bi-shop me-2 text-warning"></i>Ambil Ditempat</a></li>
                    <li><a href="#" class="link-fade"><i class="bi bi-bicycle me-2 text-warning"></i>GoFood</a></li>
                    <li><a href="#" class="link-fade"><i class="bi bi-bag-check me-2 text-warning"></i>GrabFood</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Info TJAP1 -->
            <div class="col-md-3 ">
                <h6 class="fw-bold mb-3 fs-5 text-uppercase text-accent">Info TJAP1</h6>
                <ul class="list-unstyled footer-links fs-6">
                    <li><a class="link-fade" href="{{ route('home') }}#about"><i class="bi bi-info-circle me-2 text-warning"></i>Tentang Kami</a></li>
                    <li><a class="link-fade" href="{{ route('home') }}#location"><i class="bi bi-geo-alt me-2 text-warning"></i>Lokasi</a></li>
                    <li><a class="link-fade" href="{{ route('home') }}#contact"><i class="bi bi-chat-dots me-2 text-warning"></i>Hubungi Kami!</a></li>
                    <li><a class="link-fade" href="{{ route('profile.index') }}"><i class="bi bi-person-circle me-2 text-warning"></i>Profile</a></li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="text-center small text-secondary">
            © {{ date('Y') }} | <span class="text-brand">Toko Kopi Tjap 1</span>
        </div>
    </div>

    <!-- Gambar Contact Us di pojok kanan bawah -->
    <img src="{{ asset('images/Contactus.png') }}"
         alt="Contact Us"
         class="contact-image">

    <!-- Style -->
    <style>
        footer { font-family: 'Poppins', sans-serif; overflow: hidden; position: relative; color: #f5f5f5; }
        .footer-gradient {
            /* Ganti warna footer ke nuansa cokelat kopi */
            background: linear-gradient(180deg, #3b2415 0%, #27170f 55%, #1b100a 100%) !important;
            backdrop-filter: blur(4px) saturate(1.05);
            border-top: 1px solid rgba(255, 255, 255, .06);
        }

        .text-brand { color: #ff7a2a !important; }
        .text-accent { color: #ffb266 !important; }
        .footer-desc { color: #e7e1dc; font-size: .95rem; }
        .footer-contacts { color: #ddd2cb; font-size: .95rem; }
        footer .text-secondary { color: rgba(255,255,255,.75) !important; }

        /* Links */
        .footer-links li { margin-bottom: 8px; letter-spacing: .3px; }
        .footer-links li a { color: #f1f1f1; text-decoration: none; display: inline-flex; align-items: center; gap: .45rem; transition: color .25s ease, transform .25s ease; }
        .footer-links li a:hover { color: #ffb266; transform: translateX(3px); }
        .link-light { color: #f1f1f1; }
        .link-light:hover { color: #ffb266 !important; }

        .contact-image { position: absolute; bottom: 0; right: 0; width: 380px; opacity: .95; z-index: 1; pointer-events: none; transition: transform .4s ease, opacity .4s ease; }
        .contact-image:hover { transform: scale(1.05); opacity: 1; }

        @media (max-width: 992px) { .contact-image { width: 300px; opacity: .9; } }
        @media (max-width: 768px) { .contact-image { width: 220px; opacity: .85; right: 10px; bottom: 0; } }
    </style>
</footer>
