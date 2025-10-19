<footer class="text-white pt-5 pb-3 position-relative footer-gradient">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row g-4 align-items-start">
            <!-- Kolom 1: Logo & Deskripsi -->
            <div class="col-md-5">
                <h3 class="fw-bold text-uppercase" style="color: #ff5c00;">TOKOKOPITJAP1<span class="text-white">*</span></h3>
                <p class="mt-3" style="color: #ddd; font-size: 0.95rem;">
                    Berkomitmen dalam mengembangkan bisnis secara berkelanjutan berbasis nilai, memberdayakan komunitas
                    lokal, mendukung ekspresi seni dan budaya, serta memperkuat nilai-nilai kemanusiaan.
                    Di tengah tantangan zaman, kami hadir untuk mengingatkan bahwa setiap manusia pantas dirayakan —
                    semangat kami, <strong>Berdiri Sejak Zaman Edan</strong>, dan komitmen kami dalam 
                    <span style="color: #ff5c00;">#MerayakanManusia</span>.
                </p>

                <!-- Kontak -->
                <ul class="list-unstyled mt-4" style="color: #ccc; font-size: 0.9rem;">
                    <li class="mb-2"><i class="bi bi-telephone-fill text-warning me-2"></i> 0878-2169-9178</li>
                    <li class="mb-2"><i class="bi bi-envelope-fill text-warning me-2"></i> tokokopitjap1@gmail.com</li>
                    <li><i class="bi bi-geo-alt-fill text-warning me-2"></i> Jl. Manyar II Blok 03 No. 4, Pesanggrahan, Jakarta Selatan</li>
                </ul>
            </div>

            <!-- Kolom 2: Lokasi -->
            <div class="col-md-2">
                <h6 class="fw-bold mb-3">Lokasi</h6>
                <ul class="list-unstyled footer-link">
                    <li>Bintaro Sektor 2</li>
                    <li>Bintaro Sektor 9</li>
                    <li>Pasar Santa</li>
                    <li>BSD</li>
                    <li>Gandaria</li>
                </ul>
            </div>

            <!-- Kolom 3: Order -->
            <div class="col-md-2">
                <h6 class="fw-bold mb-3">Order</h6>
                <ul class="list-unstyled footer-link">
                    <li>Lihat Menu</li>
                    <li>Reservasi</li>
                    <li>GoFood</li>
                    <li>GrabFood</li>
                    <li>Shopee Food</li>
                </ul>
            </div>

            <!-- Kolom 4: Perusahaan -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Perusahaan</h6>
                <ul class="list-unstyled footer-link">
                    <li>Tentang Kami</li>
                    <li>Investasi</li>
                    <li>Karir</li>
                    <li>Hubungi Kami!</li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="text-center small text-secondary">
            © 2025 | PT. Rasa Manusia Nusantara | <span style="color: #ff5c00;">Toko Kopi Tjap 1</span>
        </div>
    </div>

    <!-- Gambar Contact Us di pojok kanan bawah -->
    <img src="{{ asset('images/Contactus.png') }}" 
         alt="Contact Us" 
         class="contact-image">

         <style>
            footer {
                font-family: 'Poppins', sans-serif;
                overflow: hidden;
                position: relative;
            }
        
            /* Gradasi hitam lembut dan lebih tinggi */
            .footer-gradient {
                background: linear-gradient(
                    to top,
                    rgba(0, 0, 0, 0.95) 0%,     /* bawah pekat */
                    rgba(0, 0, 0, 0.85) 30%,    /* mulai menipis perlahan */
                    rgba(0, 0, 0, 0.65) 55%,    /* area tengah agak transparan */
                    rgba(0, 0, 0, 0.35) 80%,    /* semakin nyaru mendekati atas */
                    rgba(0, 0, 0, 0.0) 100%     /* transparan penuh di atas */
                );
                backdrop-filter: blur(6px);
                transition: background 0.5s ease;
            }
        
            footer ul.footer-link li {
                margin-bottom: 6px;
                color: #bbb;
                transition: color 0.3s ease;
                cursor: pointer;
            }
        
            footer ul.footer-link li:hover {
                color: #ff5c00;
            }
        
            .contact-image {
                position: absolute;
                bottom: 10px;
                right: 20px;
                width: 200px;
                opacity: 0.95;
                z-index: 1;
                pointer-events: none;
                transition: transform 0.4s ease, opacity 0.4s ease;
            }
        
            .contact-image:hover {
                transform: scale(1.05);
                opacity: 1;
            }
        
            @media (max-width: 768px) {
                .contact-image {
                    width: 130px;
                    opacity: 0.85;
                    right: 10px;
                    bottom: 0;
                }
            }
        </style>            

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</footer>