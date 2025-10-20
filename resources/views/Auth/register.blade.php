@extends('layouts.main')
@section('title', 'Daftar Akun — Toko Kopi Tjap 1')

@push('styles')
<style>
  :root { --tjap-cream:#F3E9D2; --tjap-dark-blue:#1B2A41; --tjap-gold:#C58F3B; --tjap-brown:#B98130; }

  /* Layer background terpisah (aman dari override CSS lain) */
  .bg-register{
    position:fixed; inset:0; z-index:0;
    background-color:var(--tjap-cream);
    background-image:url("/images/BGRetroHijau.png");
    background-position:center; background-size:cover;
    background-repeat:no-repeat; background-attachment:fixed;
  }

  /* Overlay gelap lembut */
  .overlay{
    position:fixed; inset:0; z-index:1;
    background:rgba(27,42,65,.40); pointer-events:none;
  }

  /* Konten di atas overlay */
  .register-container{ position:relative; z-index:2; }

  /* Kartu & form */
  .card{
    background-color:rgba(255,255,255,.92); backdrop-filter:blur(6px);
    border-radius:1rem; border:1px solid rgba(27,42,65,.15);
    box-shadow:0 8px 20px rgba(0,0,0,.1);
  }
  .form-control{
    border-radius:.6rem; border:1px solid rgba(27,42,65,.25);
    padding:.75rem 1rem; transition:.2s;
  }
  .form-control:focus{
    border-color:var(--tjap-gold);
    box-shadow:0 0 0 .15rem rgba(197,143,59,.25);
  }
  .btn-warning{
    background-color:var(--tjap-gold); border:none; border-radius:.6rem;
    transition:.2s;
  }
  .btn-warning:hover{ background-color:var(--tjap-brown); }
  .text-warning{ color:var(--tjap-gold)!important; }
  .text-warning:hover{ color:var(--tjap-brown)!important; }
</style>
@endpush

@section('content')
  <div class="bg-register"></div>
  <div class="overlay"></div>

  <div class="container py-5 register-container" style="min-height:80vh;">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-lg rounded-4">
          <div class="card-body p-4">
            <h3 class="fw-bold text-center mb-4 text-dark">Buat Akun Baru</h3>

            <form action="{{ route('register.submit') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama kamu..." required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Kata Sandi</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
              </div>
              <button type="submit" class="btn btn-warning w-100 text-white fw-semibold shadow-sm">Daftar</button>
            </form>

            <div class="text-center mt-3">
              <small class="text-muted">
                Sudah punya akun?
                <a href="{{ route('home') }}#loginModal"
                   class="text-decoration-none text-warning fw-semibold"
                   data-bs-toggle="modal" data-bs-target="#loginModal">Masuk di sini</a>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection