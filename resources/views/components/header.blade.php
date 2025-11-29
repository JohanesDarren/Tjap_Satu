<nav class="navbar navbar-expand-lg navbar-dark py-3 position-fixed w-100 top-0 custom-navbar">
  <div class="container px-4">
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('home') }}" style="letter-spacing:1px;">
      <span class="brand-dot"></span> <span class="brand-text">TOKOKOPITJAP1</span>
    </a>

    <!-- Burger -->
    <button id="navbarToggler" class="navbar-toggler border-0 shadow-none" type="button" aria-controls="navbarMain"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
      <ul class="navbar-nav align-items-lg-center ms-auto gap-lg-3">
        <li class="nav-item"><a class="nav-link menu-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link menu-link @if(request()->routeIs('tentang')) active @endif" href="{{ route('tentang') }}">Tentang</a></li>
        <li class="nav-item"><a class="nav-link menu-link @if(request()->routeIs('produk.menu')) active @endif" href="{{ route('produk.menu') }}">Menu</a></li>
        <li class="nav-item"><a class="nav-link menu-link" href="{{ route('home') }}#location">Lokasi</a></li>

        <!-- Keranjang: ikon desktop, teks mobile -->
        <li class="nav-item d-flex align-items-center gap-2">
          <a class="nav-link menu-link pe-2" href="{{ route('cart.index') }}" title="Keranjang">
            <span class="cart-icon position-relative d-none d-lg-inline-block">
              <i class="bi bi-bag fs-5"></i>
              @if(($cartCount ?? 0) > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
              @endif
            </span>
            <span class="d-inline d-lg-none">Keranjang</span>
          </a>
        </li>

        <!-- Profile Avatar -->
        <li class="nav-item d-flex align-items-center gap-2">
            @auth('customer')
              @php($cust = Auth::guard('customer')->user())
              <a href="{{ route('profile.index') }}" class="nav-link p-0 profile-link d-none d-lg-inline-flex" title="Profile">
                @if(!empty($cust->foto))
                  <img src="{{ asset('uploads/'.$cust->foto) }}" alt="{{ $cust->nama_lengkap }}" class="profile-avatar rounded-circle">
                @else
                  <div class="profile-avatar profile-fallback rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-fill"></i>
                  </div>
                @endif
              </a>
              <a href="{{ route('profile.index') }}" class="nav-link menu-link d-inline d-lg-none">Profil</a>
            @else
              <a href="#" class="nav-link p-0 profile-link d-none d-lg-inline-flex" data-bs-toggle="modal" data-bs-target="#loginModal" title="Masuk">
                <div class="profile-avatar profile-fallback rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person"></i>
                </div>
              </a>
              <a href="#" class="nav-link menu-link d-inline d-lg-none" data-bs-toggle="modal" data-bs-target="#loginModal">Profil</a>
            @endauth
        </li>

        <!-- Order -->
        <li class="nav-item mt-2 mt-lg-0">
          @auth('customer')
            <a href="{{ route('checkout.index') }}" class="btn btn-warning fw-bold text-white px-4 rounded-pill order-btn">Pesan</a>
          @else
            <a href="#" class="btn btn-warning fw-bold text-white px-4 rounded-pill order-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Pesan</a>
          @endauth
        </li>
      </ul>
    </div>
  </div>

  <style>
    /* ====== BASE ====== */
    .custom-navbar {
      z-index: 1000;
      background: transparent;
      transition: background-color .4s ease, box-shadow .4s ease;
    }

    .custom-navbar.scrolled {
      background-color: rgba(0, 0, 0, .82) !important;
      backdrop-filter: blur(8px) saturate(1.05);
      box-shadow: 0 8px 28px rgba(0, 0, 0, .3);
    }

    /* Brand */
    .brand-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      display: inline-block;
      background: #ff5c00;
      box-shadow: 0 0 8px #ff5c00;
    }

    .brand-text {
      display: inline-block;
    }

    /* Link */
    .menu-link {
      color: #fff !important;
      font-weight: 600;
      position: relative;
      letter-spacing: .2px;
    }

    .menu-link::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -3px;
      height: 2px;
      width: 0;
      background: #ff5c00;
      transition: width .25s ease;
    }

    .menu-link:hover {
      color: #ff5c00 !important;
    }

    .menu-link:hover::after {
      width: 100%;
    }

    /* Active state for current page */
    .menu-link.active,
    .menu-link:focus {
      color: #ff5c00 !important;
    }
    .menu-link.active::after { width: 100%; }

    /* Tombol Order */
    .order-btn {
      background: #ff5c00 !important;
      border: none;
      transition: transform .25s ease, box-shadow .25s ease;
    }

    .order-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 12px #ff5c00;
    }

    /* Keranjang */
    .cart-icon {
      line-height: 1;
    }

    .cart-icon i {
      color: #fff;
      transition: color .3s ease, transform .3s ease;
    }

    .cart-icon:hover i {
      color: #ff5c00;
      transform: scale(1.08);
    }

    .cart-badge {
      position: absolute;
      top: -6px;
      right: -10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 18px;
      height: 18px;
      padding: 0 6px;
      border-radius: 999px;
      background: #ff5c00;
      color: #111;
      font-size: .72rem;
      font-weight: 700;
      box-shadow: 0 0 0 2px rgba(0, 0, 0, .35);
    }

    /* Profile Avatar */
    .profile-link { display:inline-flex; align-items:center; }
    .profile-avatar { width:42px; height:42px; object-fit:cover; border:2px solid rgba(255,255,255,.35); transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease; }
    .profile-avatar:hover { transform:scale(1.06); box-shadow:0 0 0 3px rgba(255,92,0,.4); border-color:#ff5c00; }
    .profile-fallback { background:rgba(255,255,255,.12); color:#ff5c00; font-size:1.2rem; }

    @media (max-width:1199.98px){ .profile-avatar{ width:40px; height:40px; } }
    @media (max-width:991.98px){ .profile-avatar{ width:38px; height:38px; } }
    @media (max-width:767.98px){ .profile-avatar{ width:36px; height:36px; } }
    @media (max-width:575.98px){ .profile-avatar{ width:34px; height:34px; } }
    @media (max-width:360px){ .profile-avatar{ width:32px; height:32px; } }

    /* ====== BREAKPOINTS ====== */

    /* ≥1200px (Desktop besar) */
    @media (min-width: 1200px) {
      .navbar-nav {
        gap: .75rem !important;
      }

      .brand-text {
        font-size: 1.45rem;
      }

      .menu-link {
        font-size: 1rem;
      }

      .order-btn {
        padding: .55rem 1.2rem;
        font-size: 1rem;
      }

      .cart-icon i {
        font-size: 1.2rem;
      }
    }

    /* 992–1199px (Desktop/Tablet landscape) */
    @media (min-width: 992px) and (max-width: 1199.98px) {
      .navbar-nav {
        gap: .6rem !important;
      }

      .brand-text {
        font-size: 1.3rem;
      }

      .menu-link {
        font-size: .95rem;
      }

      .order-btn {
        padding: .5rem 1.1rem;
        font-size: .95rem;
      }

      .cart-icon i {
        font-size: 1.1rem;
      }
    }

    /* 768–991px (Tablet) */
    @media (min-width: 768px) and (max-width: 991.98px) {
      .container-fluid {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
      }

      .brand-text {
        font-size: 1.2rem;
      }

      .navbar-nav {
        gap: .35rem !important;
      }

      .nav-link {
        padding: .5rem 0 !important;
      }

      .menu-link {
        font-size: .95rem;
      }

      .order-btn {
        width: 100%;
        margin-top: .4rem;
        padding: .5rem 1rem;
        font-size: .95rem;
      }

      .cart-icon i {
        font-size: 1.05rem;
      }

      .cart-badge {
        min-width: 17px;
        height: 17px;
        font-size: .68rem;
        top: -6px;
        right: -9px;
      }
    }

    /* 576–767px (Mobile besar) */
    @media (min-width: 576px) and (max-width: 767.98px) {
      .container-fluid {
        padding-left: .9rem !important;
        padding-right: .9rem !important;
      }

      .brand-text {
        font-size: 1.1rem;
      }

      .navbar-nav {
        gap: .3rem !important;
      }

      .menu-link {
        font-size: .95rem;
      }

      .order-btn {
        width: 100%;
        margin-top: .45rem;
        padding: .5rem 1rem;
        font-size: .95rem;
      }

      .cart-icon i {
        font-size: 1.05rem;
      }

      .cart-badge {
        min-width: 16px;
        height: 16px;
        font-size: .66rem;
        top: -5px;
        right: -8px;
      }
    }

    /* ≤575px (Mobile kecil) */
    @media (max-width: 575.98px) {
      .container-fluid {
        padding-left: .75rem !important;
        padding-right: .75rem !important;
      }

      .brand-text {
        font-size: 1rem;
      }

      .navbar-toggler {
        padding: .3rem .5rem;
      }

      .navbar-toggler-icon {
        width: 1.2em;
        height: 1.2em;
      }

      .navbar-nav {
        gap: .2rem !important;
      }

      .menu-link {
        font-size: .92rem;
      }

      .nav-link {
        padding: .45rem 0 !important;
      }

      .order-btn {
        width: 100%;
        margin-top: .45rem;
        padding: .48rem .9rem;
        font-size: .92rem;
        border-radius: 999px;
      }

      .cart-icon i {
        font-size: 1rem;
      }

      .cart-badge {
        min-width: 15px;
        height: 15px;
        font-size: .64rem;
        top: -5px;
        right: -8px;
      }
    }

    /* ≤360px (Very small devices) */
    @media (max-width: 360px) {
      .brand-text {
        font-size: .95rem;
        letter-spacing: .3px;
      }

      .order-btn {
        font-size: .9rem;
        padding: .45rem .8rem;
      }

      .menu-link {
        font-size: .9rem;
      }
    }
  </style>

  <script>
    // Efek warna navbar saat scroll
    (function () {
      const nav = document.querySelector('.custom-navbar');
      function onScroll() {
        if (window.scrollY > 50) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
      }
      onScroll();
      window.addEventListener('scroll', onScroll);
    })();

    // FIXED BURGER MENU LOGIC
    (function () {
      const collapseEl = document.getElementById('navbarMain');
      const toggler = document.getElementById('navbarToggler');

      // Klik tombol burger → buka/tutup menu
      toggler.addEventListener('click', function () {
        const collapse = bootstrap.Collapse.getInstance(collapseEl)
          || new bootstrap.Collapse(collapseEl, { toggle: false });

        if (collapseEl.classList.contains('show')) {
          collapse.hide();
          toggler.setAttribute('aria-expanded', 'false');
        } else {
          collapse.show();
          toggler.setAttribute('aria-expanded', 'true');
        }
      });

      // Tutup menu otomatis saat klik salah satu link
      collapseEl.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
          const collapse = bootstrap.Collapse.getInstance(collapseEl);
          if (collapse && collapseEl.classList.contains('show')) {
            collapse.hide();
            toggler.setAttribute('aria-expanded', 'false');
          }
        });
      });

      // Tutup menu saat tekan ESC
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && collapseEl.classList.contains('show')) {
          const collapse = bootstrap.Collapse.getInstance(collapseEl);
          collapse.hide();
          toggler.setAttribute('aria-expanded', 'false');
        }
      });

      // Reset ke state tertutup jika layar >= 992px (desktop)
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 992 && collapseEl.classList.contains('show')) {
          const collapse = bootstrap.Collapse.getInstance(collapseEl);
          if (collapse) collapse.hide();
          toggler.setAttribute('aria-expanded', 'false');
        }
      });
    })();
  </script>
</nav>
