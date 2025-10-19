@extends('layouts.main')
@section('title', 'Daftar Akun — Toko Kopi Tjap 1')

@section('content')
  <div class="container py-5" style="min-height: 80vh;">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-lg rounded-4">
          <div class="card-body p-4">
            <h3 class="fw-bold text-center mb-4">Buat Akun Baru</h3>

            <form action="{{ route('register.submit') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama kamu..." required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
              </div>

              <button type="submit" class="btn btn-warning w-100 text-white fw-semibold">Daftar</button>
            </form>

            <div class="text-center mt-3">
              <small>Sudah punya akun?
                <a href="{{ route('home') }}#loginModal" class="text-decoration-none text-warning fw-semibold"
                  data-bs-toggle="modal" data-bs-target="#loginModal">
                  Masuk di sini
                </a>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection