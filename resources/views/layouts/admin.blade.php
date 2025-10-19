<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> {{-- perbaiki typo --}}
    <title>@yield('title', 'Admin — Toko Kopi Tjap Satu')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
</head>

<body class="bg-body-tertiary">

    {{-- Header --}}
    @include('admin.partials.header')

    <div class="d-flex">
        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Content --}}
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Toggle sidebar on mobile --}}
    <script>
        (function () {
            const sidebar = document.getElementById('adminSidebar');
            const toggler = document.querySelector('.navbar-toggler');
            if (toggler && sidebar) {
                toggler.addEventListener('click', () => {
                    sidebar.classList.toggle('show');
                });
            }
        })();
    </script>
    @stack('scripts')
</body>

</html>