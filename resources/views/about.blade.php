@extends('layouts.about-app')

@section('title', 'Tentang TJAP SATU')

@section('content')
@extends('components.header')

 {{-- CONTENT --}}
  <main>
    {{-- Flash message (opsional) --}}
    @if(session('status'))
      <div class="container pt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    @yield('content')
  </main>

    {{-- LOGIN MODAL (selalu tersedia di layout) --}}
  @include('components.login-modal')

@include('components.about.hero')
@include('components.about.cerita')
@include('components.about.filosofi')
@include('components.about.tim')
@include('components.about.asal-biji')

@include('components.footer')
@endsection
