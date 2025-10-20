<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Toko Kopi Tjap Satu')</title>

  {{-- Vendor CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Stack CSS halaman (pastikan semua view pakai @push("styles")) --}}
  @stack('styles')
</head>
<body>

  {{-- HEADER --}}
  @include('components.header')

  {{-- CONTENT --}}
  <main>
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

  {{-- LOGIN MODAL --}}
  @include('components.login-modal')

  {{-- Vendor JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Stack script halaman --}}
  @stack('scripts')
</body>
</html>
