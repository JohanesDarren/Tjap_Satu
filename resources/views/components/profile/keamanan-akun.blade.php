<h3 class="h5 fw-bold mb-4 text-dark">Keamanan Akun</h3>
<div class="card border border-light-subtle rounded-3 p-4">
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary text-uppercase">Password Saat Ini</label>
            <input type="password" name="current_password" placeholder="Masukkan password saat ini"
                class="form-control bg-light border-secondary-subtle" required>
        </div>

        <hr class="border-secondary opacity-10 my-4">

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase">Password Baru</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter"
                    class="form-control bg-light border-secondary-subtle" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="form-control bg-light border-secondary-subtle" required>
            </div>
        </div>
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-custom-green btn-sm fw-bold px-4">Ubah Password</button>
        </div>
    </form>

    <div class="mt-5 pt-4 border-top">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="btn btn-outline-danger w-100 fw-bold btn-sm d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-box-arrow-right"></i>
                Keluar
            </button>
        </form>
    </div>
</div>