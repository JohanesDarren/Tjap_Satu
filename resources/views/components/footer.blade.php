<footer class="position-relative text-white mt-5">
    <div class="footer-bg pt-5 pb-4">
        <div class="container position-relative" style="z-index: 5;">
            <div class="row g-5 justify-content-between">

                <div class="col-lg-5 col-md-12">
                    <div class="mb-4">
                        <h3 class="font-serif fw-bold ls-1 mb-2 text-white">TOKOKOPITJAP1</h3>
                        <div class="divider-line rounded-pill"></div>
                    </div>

                    <p class="footer-desc text-white-50 mb-4 pe-lg-5" style="line-height: 1.7; text-align: justify;">
                        TokoKopiTjap1 hadir sebagai gerakan untuk mengenalkan potensi biji kopi lokal Nusantara.
                        Kami percaya setiap biji memiliki cerita—tentang tanah, petani, dan semangat keberlanjutan.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="https://instagram.com/kopitjapsatu" target="_blank" class="social-pill rounded-pill">
                            <i class="bi bi-instagram"></i> <span>@kopitjapsatu</span>
                        </a>
                        <a href="mailto:tokokopitjap1@gmail.com" class="social-pill rounded-pill">
                            <i class="bi bi-envelope"></i> <span>Email</span>
                        </a>
                        <a href="https://wa.me/6287821699178" target="_blank" class="social-pill rounded-pill">
                            <i class="bi bi-whatsapp"></i> <span>WhatsApp</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <h6 class="text-uppercase fw-bold text-accent ls-2 mb-4 fs-7">Menu</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home') }}#menu">Seasonal Menu</a></li>
                        <li><a href="#">Biji Kopi</a></li>
                        <li><a href="#">Merchandise</a></li>
                        <li><a href="#">Langganan</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-6">
                    <h6 class="text-uppercase fw-bold text-accent ls-2 mb-4 fs-7">Informasi</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home') }}#about">Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}#location">Lokasi Kedai</a></li>
                        <li><a href="{{ route('profile.index') }}">Akun Member</a></li>
                        <li><span class="text-white-50">Bandung, Jawa Barat</span></li>
                    </ul>
                </div>
            </div>

            <div class="border-top border-secondary border-opacity-25 mt-5 pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <small class="text-white-50 mb-2 mb-md-0">
                    &copy; {{ date('Y') }} <span class="text-white fw-semibold">Toko Kopi Tjap 1</span>. All rights reserved.
                </small>
                <small class="text-white-50">
                    Crafted with <i class="bi bi-heart-fill text-accent mx-1" style="font-size: 0.7rem;"></i> in Bandung.
                </small>
            </div>
        </div>

        <div class="contact-image-wrapper">
             <img src="{{ asset('images/Contactus.png') }}" alt="Contact Us" class="img-fluid contact-img">
        </div>
    </div>

    <style>
        /* ====== FOOTER STYLES ====== */
        footer {
            --bg-footer: #151110;
            --accent: #AF461F;
            --text-mute: #9CA3AF;
        }

        .footer-bg {
            background-color: var(--bg-footer);
            position: relative;
            overflow: hidden; /* Mencegah gambar keluar dari area footer */
            box-shadow: 0 -10px 40px rgba(0,0,0,0.05);
        }

        .font-serif { font-family: 'Playfair Display', serif; }
        .text-accent { color: var(--accent) !important; }
        .ls-1 { letter-spacing: 1px; }
        .ls-2 { letter-spacing: 2px; }
        .fs-7 { font-size: 0.75rem; }

        .divider-line {
            width: 40px; height: 3px;
            background: var(--accent);
            border-radius: 10px;
        }

        /* Social Pills */
        .social-pill {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 20px;
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff; text-decoration: none;
            font-size: 0.85rem; transition: all 0.3s ease;
            background: rgba(255,255,255,0.03);
        }
        .social-pill:hover {
            background: var(--accent); border-color: var(--accent);
            color: #fff; transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(175, 70, 31, 0.3);
        }

        /* Links */
        .footer-links li { margin-bottom: 12px; }
        .footer-links li a {
            color: var(--text-mute); text-decoration: none;
            font-size: 0.95rem; transition: all 0.2s ease;
            display: inline-block;
        }
        .footer-links li a:hover {
            color: #fff; padding-left: 6px;
        }

        /* --- Image Decor (UPDATED) --- */
        .contact-image-wrapper {
            position: absolute;
            bottom: 0;           /* Tempel ke bawah */
            right: 0;            /* Tempel ke kanan */
            width: 300px;        /* Ukuran diperjelas */
            opacity: 1;          /* Opacity 100% agar muncul jelas */
            pointer-events: none; /* Agar tidak menghalangi klik link di atasnya */
            z-index: 1;          /* Di belakang teks container (z-index container: 5) */
        }

        .contact-img {
            display: block;
            width: 100%;
            height: auto;
            /* Opsional: Jika ingin sedikit efek gradasi bawah agar menyatu */
            -webkit-mask-image: linear-gradient(to top, black 80%, transparent 100%);
            mask-image: linear-gradient(to top, black 80%, transparent 100%);
        }

        @media (max-width: 992px) {
            /* Di layar HP/Tablet, buat lebih kecil dan transparan agar tulisan terbaca */
            .contact-image-wrapper {
                width: 200px;
                opacity: 0.15;
                right: -20px;
                bottom: -20px;
            }
        }
    </style>
</footer>
