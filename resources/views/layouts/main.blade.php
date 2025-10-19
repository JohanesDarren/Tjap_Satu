<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Toko Kopi Tjap 1')</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

  {{-- Header --}}
  @include('components.header')

  {{-- Konten halaman --}}
  <main class="pt-5 mt-5">
    @yield('content')
  </main>

  {{-- Footer jika ada --}}
  @includeIf('components.footer')

  <!-- ======================== MODAL LOGIN ======================== -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-white" style="border-radius:1rem; border:1px solid rgba(255,255,255,.1);">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-semibold" id="loginTitle">Masuk ke Akun</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <form method="POST" action="{{ route('login.attempt') }}">
          @csrf
          <div class="modal-body pt-0">
            @if($errors->login->any())
              <div class="alert alert-danger py-2">{{ $errors->login->first() }}</div>
            @endif

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input name="email" type="email"
                     class="form-control bg-transparent text-white border-secondary"
                     placeholder="nama@email.com" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input name="password" type="password"
                     class="form-control bg-transparent text-white border-secondary"
                     placeholder="••••••" required>
            </div>

            <div class="small mt-2">
              Belum punya akun?
              <a href="{{ route('signup.show') }}" class="link-warning text-decoration-none">
                Daftar di sini
              </a>
            </div>
          </div>

          <div class="modal-footer border-0">
            <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill">Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ======================== END MODAL LOGIN ======================== -->

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Auto buka modal login saat error --}}
  @if(session('showLogin') || $errors->login->any())
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const modal = new bootstrap.Modal(document.getElementById('loginModal'));
        modal.show();
      });
    </script>
  @endif
</body>
</html>
