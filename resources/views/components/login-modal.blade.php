<!-- resources/views/components/login-modal.blade.php -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4">
        <div class="modal-header bg-dark text-white rounded-top-4">
          <h5 class="modal-title" id="loginModalLabel">Masuk ke Akun</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
  
        <div class="modal-body p-4">
          <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" placeholder="masukkan email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kata Sandi</label>
              <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
  
            <button type="submit" class="btn btn-warning w-100 text-white fw-semibold">Masuk</button>
          </form>
  
          <div class="text-center mt-3">
            <small>Belum punya akun?
              <a href="{{ route('register.page') }}" class="text-decoration-none text-warning fw-semibold">
                Daftar di sini
              </a>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>  