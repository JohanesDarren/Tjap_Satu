@extends('layouts.main')
@section('title', 'Halaman Order')

@section('content')
<div class="container text-center py-5">
  <h2>Halo, {{ session('user.name') ?? 'Pengguna' }} 👋</h2>
  <p>Selamat datang di halaman Order. Kamu berhasil login!</p>
</div>
@endsection
