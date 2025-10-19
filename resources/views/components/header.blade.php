<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Toko Kopi Tjap 1</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- ======================== NAVBAR TOKO KOPI TJAP 1 ======================== -->
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
        <li class="nav-item"><a class="nav-link menu-link" href="#partnership">Menu</a></li>
        <li class="nav-item"><a class="nav-link menu-link" href="#career">Tentang</a></li>
        <li class="nav-item"><a class="nav-link menu-link" href="#stores">Lokasi</a></li>

        <!-- Keranjang -->
        <li class="nav-item">
          <a class="nav-link menu-link pe-2" href="#cart" aria-label="Keranjang">
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
          <a href="#order" class="btn btn-warning fw-bold text-white px-4 rounded-pill order-btn">Order</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  /* Navbar transparan default */
  .custom-navbar{
    z-index:1000; background:transparent;
    transition: background-color .4s ease, box-shadow .4s ease;
  }
  /* Saat scroll, jadi gelap */
  .custom-navbar.scrolled{
    background-color: rgba(0,0,0,.82) !important;
    backdrop-filter: blur(6px);
    box-shadow: 0 6px 24px rgba(0,0,0,.25);
  }

  /* Titik oranye di logo */
  .brand-dot{ width:10px; height:10px; border-radius:50%; display:inline-block; background:#ff5c00; box-shadow:0 0 8px #ff5c00; }

  /* Link menu */
  .menu-link{ color:#fff !important; font-weight:600; position:relative; letter-spacing:.2px; }
  .menu-link::after{ content:""; position:absolute; left:0; bottom:-3px; height:2px; width:0; background:#ff5c00; transition:width .25s ease; }
  .menu-link:hover{ color:#ff5c00 !important; }
  .menu-link:hover::after{ width:100%; }

  /* Tombol Order */
  .order-btn{ background:#ff5c00 !important; border:none; transition:transform .25s ease, box-shadow .25s ease; }
  .order-btn:hover{ transform:scale(1.05); box-shadow:0 0 12px #ff5c00; }

  /* Ikon keranjang */
  .cart-icon{ line-height:1; }
  .cart-icon i{ color:#fff; transition: color .3s ease, transform .3s ease; }
  .cart-icon:hover i{ color:#ff5c00; transform:scale(1.1); }

  /* Badge keranjang */
  .cart-badge{
    position:absolute; top:-6px; right:-10px;
    display:inline-flex; align-items:center; justify-content:center;
    min-width:18px; height:18px; padding:0 6px; border-radius:999px;
    background:#ff5c00; color:#111; font-size:.72rem; font-weight:700;
    box-shadow:0 0 0 2px rgba(0,0,0,.35);
  }

  /* Responsif (mobile & tablet) */
  @media (max-width: 991.98px){
    .navbar-nav{ gap:.25rem !important; }
    .nav-link{ padding:.5rem 0 !important; }
    .order-btn{ width:100%; margin-top:.5rem; }
  }
</style>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Navbar darken on scroll
  (function () {
    const nav = document.querySelector('.custom-navbar');
    const onScroll = () => window.scrollY > 50 ? nav.classList.add('scrolled') : nav.classList.remove('scrolled');
    onScroll();
    window.addEventListener('scroll', onScroll);
  })();

  // ================== Burger Logic (toggle open/close) ==================
  (function(){
    const collapseEl = document.getElementById('navbarMain');
    const toggler = document.getElementById('navbarToggler');

    // Bootstrap Collapse instance (manual control)
    const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });

    // Toggle on button click (klik = buka, klik lagi = tutup)
    toggler.addEventListener('click', function(){
      bsCollapse.toggle();
      // sinkronkan aria-expanded untuk aksesibilitas
      const isOpen = collapseEl.classList.contains('show');
      toggler.setAttribute('aria-expanded', String(isOpen));
    });

    // Tutup saat klik salah satu link (UX mobile)
    collapseEl.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        if (collapseEl.classList.contains('show')) {
          bsCollapse.hide();
          toggler.setAttribute('aria-expanded', 'false');
        }
      });
    });

    // Tutup saat tekan ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && collapseEl.classList.contains('show')) {
        bsCollapse.hide();
        toggler.setAttribute('aria-expanded', 'false');
      }
    });

    // Reset ke state tertutup saat resize >= lg (hindari “nyangkut”)
    const mq = window.matchMedia('(min-width: 992px)');
    const handleResize = (e) => {
      if (e.matches) { // masuk desktop
        bsCollapse.hide();
        toggler.setAttribute('aria-expanded', 'false');
      }
    };
    mq.addEventListener('change', handleResize);
  })();
</script>

</body>
</html>
