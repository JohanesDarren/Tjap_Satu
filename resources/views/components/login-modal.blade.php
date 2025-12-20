<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-body); border-radius: 32px; overflow: hidden;">

        <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5">
          <div class="text-center mb-5 mt-2">
              <h2 class="modal-title mb-2" id="loginModalLabel" style="font-family: var(--font-display); font-weight: 700; color: var(--color-primary);">
                  Welcome Back
              </h2>
              <p class="text-muted small">Silakan masuk untuk melanjutkan pesanan.</p>
          </div>

          @if ($errors->has('email'))
            <div class="alert alert-danger py-2 mb-3 rounded-4 border-0 bg-danger text-white text-center fs-7">
              <i class="bi bi-exclamation-circle me-2"></i> {{ $errors->first('email') }}
            </div>
          @endif

          <form action="{{ session('admin_login') ? route('admin.login.submit') : route('login.submit') }}" method="POST" novalidate>
            @csrf
            <div class="mb-4">
              <label class="form-label small text-uppercase fw-bold ls-1 text-muted ms-3">Email Address</label>
              <input type="email" name="email" class="form-control form-control-lg rounded-pill px-4"
                     placeholder="nama@email.com" value="{{ old('email') }}" required
                     style="background: #fff; border: 1px solid #e0e0e0; font-size: 0.95rem; color: var(--color-primary);">
              @error('email')
                <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-4 position-relative">
              <label class="form-label small text-uppercase fw-bold ls-1 text-muted ms-3">Password</label>
              <div class="position-relative">
                  <input id="login_password" type="password" name="password" class="form-control form-control-lg rounded-pill px-4"
                         placeholder="••••••••" required
                         style="background: #fff; border: 1px solid #e0e0e0; font-size: 0.95rem; color: var(--color-primary);">
                  <button type="button" class="btn border-0 position-absolute end-0 top-50 translate-middle-y me-3 text-muted"
                          data-toggle-password="#login_password">
                      <i class="bi bi-eye"></i>
                  </button>
              </div>
              @error('password')
                <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-grid mt-5">
              <button type="submit" class="btn btn-dark btn-lg rounded-pill py-3 fw-bold"
                      style="background-color: var(--color-primary); border: none; letter-spacing: 1px; font-size: 0.9rem;">
                  MASUK SEKARANG
              </button>
            </div>
          </form>

          <div class="text-center mt-4 pt-3">
            <p class="text-muted small mb-0">Belum punya akun?
              <a href="{{ route('register.page') }}" class="text-decoration-none fw-bold" style="color: var(--color-accent);">
                Daftar Member
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(session('show_login'))
    <script>
      document.addEventListener('DOMContentLoaded', function(){
        const m = document.getElementById('loginModal');
        if (m) new bootstrap.Modal(m).show();
      });

      // Toggle Password Script
      document.querySelectorAll('[data-toggle-password]').forEach(btn => {
          btn.addEventListener('click', () => {
              const input = document.querySelector(btn.getAttribute('data-toggle-password'));
              const icon = btn.querySelector('i');
              if(input.type === 'password'){
                  input.type = 'text';
                  icon.classList.replace('bi-eye', 'bi-eye-slash');
              } else {
                  input.type = 'password';
                  icon.classList.replace('bi-eye-slash', 'bi-eye');
              }
          });
      });
    </script>
  @endif
