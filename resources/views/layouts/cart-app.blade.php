<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TJAP SATU')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
  </head>
    @yield('scripts')
  <body >

    <main class="container py-5">
      @yield('content')
    </main>
@include('components.footer')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tombol Pilih Semua
            const selectAll = document.getElementById('select-all');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');

            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(cb => cb.checked = selectAll.checked);
            });

            itemCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    selectAll.checked = Array.from(itemCheckboxes).every(item => item.checked);
                });
            });

            // Tombol + / − quantity
            const cartRows = document.querySelectorAll('.quantity-group');
            cartRows.forEach(row => {
                const input = row.querySelector('.qty-input');
                const btnInc = row.querySelector('.btn-increase');
                const btnDec = row.querySelector('.btn-decrease');

                btnInc.addEventListener('click', () => {
                    input.value = parseInt(input.value) + 1;
                });

                btnDec.addEventListener('click', () => {
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                    }
                });
            });
        });
    </script>
  </body>
</html>
