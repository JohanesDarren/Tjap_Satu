<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

      {{-- MODIFIKASI: Dark Glass Effect (Warna Gelap Transparan + Blur) --}}
      <div class="modal-content border-0 shadow-lg"
           style="background-color: rgba(44, 54, 57, 0.85); /* Warna Primary Transparan */
                  -webkit-backdrop-filter: blur(10px); /* Support untuk Safari/iOS */
                  backdrop-filter: blur(10px);
                  border: 1px solid rgba(255, 255, 255, 0.1);
                  border-radius: 32px;
                  color: #fff; /* Text Putih */
                  overflow: hidden;">

        <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
          {{-- Tombol Close Putih --}}
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5">
          <div class="text-center mb-5 mt-2">
              <h2 class="modal-title mb-2" id="loginModalLabel" style="font-family: var(--font-display); font-weight: 700; color: #fff;">
                  Welcome Back
              </h2>
              <p class="text-white-50 small">Silakan masuk untuk melanjutkan pesanan.</p>
          </div>

          @if ($errors->has('email'))
            <div class="alert alert-danger py-2 mb-3 rounded-4 border-0 bg-danger text-white text-center fs-7">
              <i class="bi bi-exclamation-circle me-2"></i> {{ $errors->first('email') }}
            </div>
          @endif

          <form action="{{ session('admin_login') ? route('admin.login.submit') : route('login.submit') }}" method="POST" novalidate>
            @csrf
            <div class="mb-4">
              <label class="form-label small text-uppercase fw-bold ls-1 text-white-50 ms-3">Email Address</label>
              {{-- Input field putih semi-transparan --}}
              <input type="email" name="email" class="form-control form-control-lg rounded-pill px-4"
                     placeholder="nama@email.com" value="{{ old('email') }}" required
                     style="background: rgba(255, 255, 255, 0.1);
                            border: 1px solid rgba(255, 255, 255, 0.2);
                            color: #fff;
                            font-size: 0.95rem;">
              @error('email')
                <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-4 position-relative">
              <label class="form-label small text-uppercase fw-bold ls-1 text-white-50 ms-3">Password</label>
              <div class="position-relative">
                  <input id="login_password" type="password" name="password" class="form-control form-control-lg rounded-pill px-4"
                         placeholder="••••••••" required
                         style="background: rgba(255, 255, 255, 0.1);
                                border: 1px solid rgba(255, 255, 255, 0.2);
                                color: #fff;
                                font-size: 0.95rem;
                                padding-right: 3rem;">

                  {{-- Tombol Mata --}}
                  <button type="button" class="btn border-0 position-absolute end-0 top-50 translate-middle-y me-3 text-white-50"
                          onclick="toggleLoginPassword()"
                          style="z-index: 10; cursor: pointer;">
                      <i class="bi bi-eye" id="login_eye_icon"></i>
                  </button>
              </div>
              @error('password')
                <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-grid mt-5">
              {{-- Tombol Aksen (Coklat/Gold) agar kontras dengan background gelap --}}
              <button type="submit" class="btn btn-lg rounded-pill py-3 fw-bold"
                      style="background-color: var(--color-accent); color: #fff; border: none; letter-spacing: 1px; font-size: 0.9rem; transition: all 0.3s;">
                  MASUK SEKARANG
              </button>
            </div>
          </form>

          <div class="text-center mt-4 pt-3">
            <p class="text-white-50 small mb-0">Belum punya akun?
              <a href="{{ route('home') }}#register" onclick="var m=bootstrap.Modal.getInstance(document.getElementById('loginModal')); if(m) m.hide();" class="text-decoration-none fw-bold" style="color: var(--color-accent);">
                Daftar Member
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
</div>

{{-- Script CSS Fix untuk Placeholder Input agar berwarna putih transparan --}}
<style>
    #loginModal input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }
    #loginModal input:focus {
        background: rgba(255, 255, 255, 0.2) !important;
        border-color: var(--color-accent) !important;
        box-shadow: none !important;
        color: #fff !important;
    }
    /* Fix Autocomplete browser background */
    #loginModal input:-webkit-autofill,
    #loginModal input:-webkit-autofill:hover,
    #loginModal input:-webkit-autofill:focus {
        -webkit-text-fill-color: #fff !important;
        -webkit-box-shadow: 0 0 0px 1000px rgba(44, 54, 57, 0) inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        @if(session('show_login'))
            const m = document.getElementById('loginModal');
            if (m) new bootstrap.Modal(m).show();
        @endif
    });

    function toggleLoginPassword() {
        const input = document.getElementById('login_password');
        const icon = document.getElementById('login_eye_icon');

        if(input.type === 'password'){
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
