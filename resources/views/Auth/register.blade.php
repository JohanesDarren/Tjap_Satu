@extends('layouts.main')
@section('title','Daftar Akun')

@section('content')
<div class="container py-5" style="max-width: 520px;">
  <div class="card bg-dark text-white" style="border-radius:1rem; border:1px solid rgba(255,255,255,.1);">
    <div class="card-body p-4 p-md-5">
      <h3 class="fw-semibold mb-3">Daftar Akun</h3>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="post" action="{{ route('signup.attempt') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="name" class="form-control bg-transparent text-white border-secondary" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control bg-transparent text-white border-secondary" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control bg-transparent text-white border-secondary" required>
        </div>

        <div class="mb-4">
          <label class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="form-control bg-transparent text-white border-secondary" required>
        </div>

        <button class="btn btn-warning w-100 fw-bold rounded-pill">Daftar</button>

        <div class="small mt-3 text-center">
          Sudah punya akun?
          <a href="#" class="link-warning text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk di sini</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection