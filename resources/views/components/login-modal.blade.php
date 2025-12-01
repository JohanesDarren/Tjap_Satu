<!-- resources/views/components/login-modal.blade.php -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 glass-card"><!-- apply glass effect to match register form -->
      <div class="modal-header text-white rounded-top-4" style="background: linear-gradient(135deg, var(--rust, #AF461F), #c96931);"><!-- rust gradient header -->
        <h5 class="modal-title" id="loginModalLabel">Masuk ke Akun</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        @if ($errors->has('email'))
          <div class="alert alert-danger py-2 mb-3">{{ $errors->first('email') }}</div>
        @endif

        <form action="{{ session('admin_login') ? route('admin.login.submit') : route('login.submit') }}" method="POST" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label input-label text-white">Email</label>
            <input type="email" name="email" class="form-control glass-input @error('email') is-invalid @enderror" placeholder="masukkan email" value="{{ old('email') }}" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-1 pw-wrap">
            <label class="form-label input-label text-white">Kata Sandi</label>
            <input id="login_password" type="password" name="password" class="form-control glass-input @error('password') is-invalid @enderror" placeholder="••••••••" required>
            <button type="button" class="pw-toggle" aria-label="Tampilkan/sembunyikan sandi" data-toggle-password="#login_password">👁️</button>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-gradient w-100 fw-semibold">Masuk</button>
        </form>

        <div class="text-center mt-3">
          <small class="text-white">Belum punya akun?
            <a href="{{ route('register.page') }}" class="text-decoration-none link-rust fw-semibold">
              Daftar di sini
            </a>
          </small>
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
  </script>
@endif
