<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>@yield('title', 'Toko Kopi Tjap Satu')</title> {{-- Judul default --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>

    <style>
        :root {
            --tjap-cream: #F3E9D2;
            --tjap-dark-blue: #1B2A41;
        }
        body {
            background-color: var(--tjap-cream);
            font-family: 'Roboto', sans-serif;
            color: var(--tjap-dark-blue);

        }
    </style>
</head>
<body>

    <main class="container my-5">
        @yield('content')
    </main>
    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>