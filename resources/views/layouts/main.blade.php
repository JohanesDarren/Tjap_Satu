<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Toko Kopi Tjap 1')</title>

  {{-- Stack CSS halaman --}}
  @stack('head')
</head>
<body>

  {{-- HEADER --}}
  @include('components.header')

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

  {{-- FOOTER --}}
  @includeIf('components.footer')

  {{-- LOGIN MODAL (selalu tersedia di layout) --}}
  @include('components.login-modal')

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Stack script halaman --}}
  @stack('scripts')
</body>
</html>