<body>
    @include('components.header')
    <main class="container my-5">
        @yield('content')
    </main>
    @include('components.footer')

    @yield('scripts')
</body>
</html>
