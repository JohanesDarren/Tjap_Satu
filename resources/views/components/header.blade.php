<nav class="navbar navbar-expand-lg navbar-dark py-3 position-fixed w-100 top-0 custom-navbar">
  <div class="container-fluid px-4">
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="/" style="letter-spacing:1px;">
      <span class="brand-dot"></span> TOKOKOPITJAP1
    </a>

    <!-- Burger -->
    <button id="navbarToggler" class="navbar-toggler border-0 shadow-none" type="button"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
      <ul class="navbar-nav align-items-lg-center ms-auto gap-lg-3">
        <li class="nav-item"><a class="nav-link menu-link" href="#about">Home</a></li>
        <li class="nav-item"><a class="nav-link menu-link" href="#menu">Menu</a></li>
        <li class="nav-item"><a class="nav-link menu-link" href="#about">Tentang</a></li>
        <li class="nav-item"><a class="nav-link menu-link" href="#location">Lokasi</a></li>

        <!-- Keranjang -->
        <li class="nav-item">
          <a class="nav-link menu-link pe-2" href="#cart">
            <span class="cart-icon position-relative d-inline-block">
              <i class="bi bi-bag fs-5"></i>
              @if(($cartCount ?? 0) > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
              @endif
            </span>
            <span class="d-lg-none ms-2">Keranjang</span>
          </a>
        </li>

        <!-- Order -->
        <li class="nav-item mt-2 mt-lg-0">
          @if(session('user'))
            {{-- Sudah login --}}
            <a href="{{ route('order.index') }}" class="btn btn-warning fw-bold text-white px-4 rounded-pill order-btn">
              Order
            </a>
          @else
            {{-- Belum login -> buka modal --}}
            <a href="#" class="btn btn-warning fw-bold text-white px-4 rounded-pill order-btn"
               data-bs-toggle="modal" data-bs-target="#loginModal">
              Order
            </a>
          @endif
        </li>
      </ul>
    </div>
  </div>

  <style>
    .custom-navbar {
      z-index: 1000; background: transparent;
      transition: background-color .4s, box-shadow .4s;
    }
    .custom-navbar.scrolled {
      background-color: rgba(0,0,0,.82)!important;
      backdrop-filter: blur(6px);
      box-shadow: 0 6px 24px rgba(0,0,0,.25);
    }
    .brand-dot {
      width: 10px; height: 10px; border-radius: 50%;
      display: inline-block; background: #ff5c00; box-shadow: 0 0 8px #ff5c00;
    }
    .menu-link { color: #fff!important; font-weight: 600; position: relative; }
    .menu-link::after { content: ""; position: absolute; left: 0; bottom: -3px; height: 2px; width: 0; background: #ff5c00; transition: width .25s; }
    .menu-link:hover { color: #ff5c00!important; }
    .menu-link:hover::after { width: 100%; }
    .order-btn { background: #ff5c00!important; border: none; transition: transform .25s, box-shadow .25s; }
    .order-btn:hover { transform: scale(1.05); box-shadow: 0 0 12px #ff5c00; }
    .cart-icon i { color: #fff; transition: color .3s, transform .3s; }
    .cart-icon:hover i { color: #ff5c00; transform: scale(1.1); }
    .cart-badge {
      position: absolute; top: -6px; right: -10px;
      display: inline-flex; align-items: center; justify-content: center;
      min-width: 18px; height: 18px; padding: 0 6px;
      border-radius: 999px; background: #ff5c00; color: #111;
      font-size: .72rem; font-weight: 700;
      box-shadow: 0 0 0 2px rgba(0,0,0,.35);
    }
    @media (max-width: 991.98px) {
      .navbar-nav { gap: .25rem!important; }
      .order-btn { width: 100%; margin-top: .5rem; }
    }
  </style>

  <script>
    // Navbar jadi gelap saat scroll
    (function(){
      const nav = document.querySelector('.custom-navbar');
      const onScroll = () => window.scrollY > 50 ? nav.classList.add('scrolled') : nav.classList.remove('scrolled');
      onScroll(); window.addEventListener('scroll', onScroll);
    })();

    // Burger menu logic
    (function(){
      const collapseEl = document.getElementById('navbarMain');
      const toggler = document.getElementById('navbarToggler');
      const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });
      toggler.addEventListener('click', function(){
        bsCollapse.toggle();
        const isOpen = collapseEl.classList.contains('show');
        toggler.setAttribute('aria-expanded', String(isOpen));
      });
      collapseEl.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
          if (collapseEl.classList.contains('show')) {
            bsCollapse.hide();
            toggler.setAttribute('aria-expanded', 'false');
          }
        });
      });
    })();
  </script>
</nav>