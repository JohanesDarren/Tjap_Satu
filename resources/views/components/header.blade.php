<nav class="navbar navbar-expand-lg navbar-dark py-3 position-fixed w-100 top-0"
    style="z-index: 1000; background: transparent;">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand fw-bold text-white" href="/" style="font-size: 1.5rem; letter-spacing: 1px;">
            TOKOKOPITJAP1<span class="text-warning">*</span>
        </a>

        <!-- Toggle (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-3">
                <li class="nav-item"><a class="nav-link menu-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link menu-link" href="#partnership">Partnership</a></li>
                <li class="nav-item"><a class="nav-link menu-link" href="#career">Career</a></li>
                <li class="nav-item"><a class="nav-link menu-link" href="#menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link menu-link" href="#stores">Stores</a></li>
                <li class="nav-item">
                    <a href="#order" class="btn btn-warning fw-bold text-white px-4 rounded-pill order-btn">
                        Order Online
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Inline CSS -->
    <style>
        /* Navbar transparan */
        nav {
            transition: background-color 0.4s ease;
        }

        /* Efek saat di-scroll (menjadi gelap semi transparan) */
        .scrolled {
            background-color: rgba(0, 0, 0, 0.8) !important;
            backdrop-filter: blur(6px);
        }

        /* Link menu dasar */
        .menu-link {
            color: #ffffff !important;
            position: relative;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        /* Animasi garis bawah */
        .menu-link::after {
            content: "";
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #ff5c00;
            transition: width 0.3s ease;
        }

        /* Hover efek */
        .menu-link:hover {
            color: #ff5c00 !important;
        }

        .menu-link:hover::after {
            width: 100%;
        }

        /* Tombol Order Online */
        .order-btn {
            background-color: #ff5c00 !important;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .order-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px #ff5c00;
        }
    </style>

    <!-- Script efek scroll -->
    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</nav>