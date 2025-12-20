<nav class="navbar navbar-expand-lg navbar-dark py-3 position-fixed w-100 top-0 custom-navbar">
    <div class="container px-4">
      <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('home') }}">
        <span class="brand-dot"></span>
        <span class="brand-text">TOKOKOPITJAP1</span>
      </a>

      <button id="navbarToggler" class="navbar-toggler border-0 shadow-none p-2" type="button" aria-controls="navbarMain"
        aria-expanded="false" aria-label="Toggle navigation">
        <div class="burger-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
        <ul class="navbar-nav align-items-lg-center ms-auto gap-lg-4 p-3 p-lg-0 mt-3 mt-lg-0 mobile-nav-bg">
          <li class="nav-item"><a class="nav-link menu-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}">Beranda</a></li>
          <li class="nav-item"><a class="nav-link menu-link @if(request()->routeIs('tentang')) active @endif" href="{{ route('tentang') }}">Tentang</a></li>
          <li class="nav-item"><a class="nav-link menu-link @if(request()->routeIs('produk.menu')) active @endif" href="{{ route('produk.menu') }}">Menu</a></li>
          <li class="nav-item"><a class="nav-link menu-link" href="{{ route('home') }}#location">Lokasi</a></li>

          <li class="nav-item d-flex align-items-center gap-2 my-2 my-lg-0">
            <a class="nav-link menu-link pe-2 position-relative" href="{{ route('cart.index') }}" title="Keranjang">
              <span class="cart-icon d-none d-lg-inline-block">
                <i class="bi bi-handbag fs-5"></i>
                @if(($cartCount ?? 0) > 0)
                  <span class="cart-badge shadow-sm">{{ $cartCount }}</span>
                @endif
              </span>
              <span class="d-inline d-lg-none">Keranjang @if(($cartCount ?? 0) > 0) ({{ $cartCount }}) @endif</span>
            </a>
          </li>

          <li class="nav-item d-flex align-items-center gap-2 ms-lg-2">
              @auth('customer')
                @php($cust = Auth::guard('customer')->user())
                <a href="{{ route('profile.index') }}" class="nav-link p-0 profile-link d-none d-lg-inline-flex" title="Profile">
                  @if(!empty($cust->foto))
                    <img src="{{ asset('uploads/'.$cust->foto) }}" alt="{{ $cust->nama_lengkap }}" class="profile-avatar rounded-circle shadow-sm">
                  @else
                    <div class="profile-avatar profile-fallback rounded-circle shadow-sm d-flex align-items-center justify-content-center">
                      <span class="initials">{{ substr($cust->nama_lengkap ?? 'User', 0, 1) }}</span>
                    </div>
                  @endif
                </a>
                <a href="{{ route('profile.index') }}" class="nav-link menu-link d-inline d-lg-none">Profil Saya</a>
              @else
                <a href="#" class="nav-link p-0 profile-link d-none d-lg-inline-flex" data-bs-toggle="modal" data-bs-target="#loginModal" title="Masuk">
                  <div class="profile-avatar profile-fallback rounded-circle shadow-sm d-flex align-items-center justify-content-center">
                    <i class="bi bi-person"></i>
                  </div>
                </a>
                <a href="#" class="nav-link menu-link d-inline d-lg-none" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk / Daftar</a>
              @endauth
          </li>

          <li class="nav-item mt-3 mt-lg-0 ms-lg-2">
            @auth('customer')
              <a href="{{ route('checkout.index') }}" class="btn btn-primary-coffee px-4 py-2 rounded-pill shadow-sm order-btn">Pesan</a>
            @else
              <a href="#" class="btn btn-primary-coffee px-4 py-2 rounded-pill shadow-sm order-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Pesan</a>
            @endauth
          </li>
        </ul>
      </div>
    </div>

    <style>
      /* ====== VARIABLES ====== */
      nav {
          --coffee-dark: #1F1B1A;
          --coffee-accent: #AF461F; /* Rust Orange */
          --coffee-gold: #D4C5A9;
          --coffee-glass: rgba(31, 27, 26, 0.9);
          /* Variabel --radius-nav DIHILANGKAN */
      }

      /* ====== NAVBAR BASE ====== */
      .custom-navbar {
        z-index: 1050;
        background: transparent;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      }

      /* Navbar Scrolled State - BORDER RADIUS DIHILANGKAN */
      .custom-navbar.scrolled {
        background-color: var(--coffee-glass) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding-top: 0.8rem !important;
        padding-bottom: 0.8rem !important;
        /* Properti border-bottom-left-radius & border-bottom-right-radius telah dihapus */
        margin-top: 0;
      }

      /* Brand */
      .brand-dot {
        width: 10px; height: 10px;
        background: var(--coffee-accent);
        border-radius: 50%; display: inline-block;
        box-shadow: 0 0 12px var(--coffee-accent);
      }
      .brand-text {
        font-family: 'Playfair Display', serif;
        font-weight: 700; letter-spacing: 1px; font-size: 1.3rem;
        color: #fff !important;
      }

      /* Links */
      .menu-link {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: rgba(255,255,255,0.8) !important;
        font-weight: 500; font-size: 0.95rem;
        position: relative; transition: color 0.3s ease;
      }
      .menu-link:hover, .menu-link.active { color: #fff !important; }

      /* Underline Animation */
      .menu-link::after {
        content: ""; position: absolute; left: 50%; bottom: 2px;
        width: 0; height: 2px;
        background: var(--coffee-accent);
        transition: all 0.3s ease; transform: translateX(-50%);
      }
      .menu-link:hover::after, .menu-link.active::after { width: 80%; }

      /* Buttons */
      .btn-primary-coffee {
        background: linear-gradient(135deg, var(--coffee-accent), #8a3a1b);
        color: #fff !important; border: none;
        font-weight: 600; letter-spacing: 0.5px;
        font-size: 0.9rem; text-transform: uppercase;
        transition: all 0.3s ease;
      }
      .btn-primary-coffee:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(175, 70, 31, 0.4) !important;
        filter: brightness(1.1);
      }

      /* Cart Badge */
      .cart-badge {
        position: absolute; top: -5px; right: -8px;
        background: var(--coffee-accent); color: #fff;
        font-size: 0.65rem; width: 18px; height: 18px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        border: 2px solid var(--coffee-dark);
      }

      /* Profile Avatar */
      .profile-avatar {
        width: 40px; height: 40px; object-fit: cover;
        border: 2px solid rgba(255,255,255,0.2);
        transition: transform 0.3s ease, border-color 0.3s ease;
      }
      .profile-fallback {
        background: rgba(255,255,255,0.1); color: var(--coffee-gold);
        font-weight: 700;
      }
      .profile-link:hover .profile-avatar {
        border-color: var(--coffee-accent); transform: scale(1.08);
      }

      /* Burger Icon */
      .burger-icon span {
          display: block; width: 24px; height: 2px;
          background-color: #fff; margin: 6px 0;
          transition: 0.4s; border-radius: 2px;
      }
      .navbar-toggler[aria-expanded="true"] .burger-icon span:nth-child(1) { transform: rotate(-45deg) translate(-5px, 6px); }
      .navbar-toggler[aria-expanded="true"] .burger-icon span:nth-child(2) { opacity: 0; }
      .navbar-toggler[aria-expanded="true"] .burger-icon span:nth-child(3) { transform: rotate(45deg) translate(-5px, -6px); }

      /* Mobile Menu */
      @media (max-width: 991.98px) {
        .mobile-nav-bg {
          background: rgba(31, 27, 26, 0.95);
          backdrop-filter: blur(15px);
          -webkit-backdrop-filter: blur(15px);
          box-shadow: 0 15px 40px rgba(0,0,0,0.4);
          border: 1px solid rgba(255,255,255,0.08);
          /* BORDER RADIUS DIHILANGKAN UNTUK MOBILE MENU */
          border-radius: 0;
        }
        .menu-link { padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .menu-link::after { display: none; }
        .order-btn { width: 100%; text-align: center; }
      }
    </style>

    <script>
      (function () {
        const nav = document.querySelector('.custom-navbar');
        function onScroll() {
          if (window.scrollY > 30) nav.classList.add('scrolled');
          else nav.classList.remove('scrolled');
        }
        window.addEventListener('scroll', onScroll);
        onScroll();

        // Close menu on click outside
        const collapseEl = document.getElementById('navbarMain');
        const toggler = document.getElementById('navbarToggler');
        document.addEventListener('click', (e) => {
          if (!nav.contains(e.target) && collapseEl.classList.contains('show')) {
             new bootstrap.Collapse(collapseEl).hide();
             toggler.setAttribute('aria-expanded', 'false');
          }
        });
      })();
    </script>
  </nav>
