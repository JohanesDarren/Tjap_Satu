<footer class="text-white position-relative footer-gradient">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row g-4 align-items-start">
            <!-- Kolom 1: Logo & Deskripsi -->
            <div class="col-md-5">
                <h3 class="fw-bold text-uppercase" style="color: #ff5c00;">TOKOKOPITJAP1</h3>
                <p class="mt-3" style="color: #ddd; font-size: 0.95rem;">
                    TokoKopiTjap1 hadir sebagai gerakan untuk mengenalkan dan mengangkat potensi biji kopi lokal Nusantara. Kami percaya bahwa setiap biji kopi memiliki cerita — tentang tanah tempat ia tumbuh, tentang tangan yang merawatnya, dan tentang semangat masyarakat yang menjaganya. Melalui kolaborasi dengan petani dan pelaku usaha kecil, kami berkomitmen menghadirkan biji kopi berkualitas dengan prinsip keberlanjutan dan nilai kemanusiaan. Dari ladang hingga ke tangan penikmatnya, kami ingin menjaga cita rasa dan makna di setiap prosesnya.
                    Inilah semangat kami dalam 
                    <span style="color: #ff5c00;">#KopiRakyatNusantara</span> — merayakan kerja keras, rasa, dan kebanggaan atas hasil bumi sendiri.
                </p>

                <!-- Kontak -->
                <ul class="list-unstyled mt-4" style="color: #ccc; font-size: 0.95rem;">
                    <li class="mb-2">
                        <i class="bi bi-telephone-fill text-warning me-2"></i> 0878-2169-9178
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope-fill text-warning me-2"></i>
                        <a href="mailto:tokokopitjap1@gmail.com" class="text-decoration-none text-light">tokokopitjap1@gmail.com</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-instagram text-warning me-2"></i>
                        <a href="https://www.instagram.com/kopitjapsatu/" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-light">
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
                <h6 class="fw-bold mb-3 fs-5 text-uppercase" style="color: #ff8a33;">Order</h6>
                <ul class="list-unstyled footer-link fs-6">
                    <li>Lihat Menu</li>
                    <li>Ambil Ditempat</li>
                    <li>GoFood</li>
                    <li>GrabFood</li>
                </ul>
            </div>

            <!-- Kolom 3: Info TJAP1 -->
            <div class="col-md-3 ">
                <h6 class="fw-bold mb-3 fs-5 text-uppercase" style="color: #ff8a33;">Info TJAP1</h6>
                <ul class="list-unstyled footer-link fs-6">
                    <li>Tentang Kami</li>
                    <li>Lokasi</li>
                    <li>Hubungi Kami!</li>
                    <a class="text-decoration-none" href="{{ route('profile.index') }}"><li>Profile</li></a>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="text-center small text-secondary">
            © 2025 | <span style="color: #ff5c00;">Toko Kopi Tjap 1</span>
        </div>
    </div>

    <!-- Gambar Contact Us di pojok kanan bawah -->
    <img src="{{ asset('images/Contactus.png') }}" 
         alt="Contact Us" 
         class="contact-image">

    <!-- Style -->
    <style>
        footer {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            position: relative;
            color: #f5f5f5;
        }

        .footer-gradient {
            background: linear-gradient(
                to top,
                rgba(0, 0, 0, 0.95) 0%,
                rgba(0, 0, 0, 0.85) 30%,
                rgba(0, 0, 0, 0.65) 55%,
                rgba(0, 0, 0, 0.35) 80%,
                rgba(0, 0, 0, 0.0) 100%
            );
            backdrop-filter: blur(6px);
        }

        footer ul.footer-link li {
            margin-bottom: 8px;
            color: #e0e0e0;
            transition: color 0.3s ease;
            cursor: pointer;
            letter-spacing: 0.3px;
        }

        footer ul.footer-link li:hover {
            color: #ff8a33;
            transform: translateX(3px);
        }

        footer a.text-light:hover {
            color: #ff8a33 !important;
        }

        .contact-image {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 420px; /* sebelumnya 300px */
            opacity: 0.95;
            z-index: 1;
            pointer-events: none;
            transition: transform 0.4s ease, opacity 0.4s ease;
        }

        .contact-image:hover {
            transform: scale(1.08);
            opacity: 1;
        }

        @media (max-width: 768px) {
            .contact-image {
                width: 220px; /* tetap lebih besar di mobile */
                opacity: 0.85;
                right: 10px;
                bottom: 0;
            }
        }
    </style>
</footer>