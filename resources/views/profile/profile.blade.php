<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Tjap Satu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>

<body>

    <div
        class="fixed-top d-md-none mobile-header shadow-sm px-3 py-3 d-flex justify-content-between align-items-center">
        <a href="/" class="text-decoration-none text-secondary d-flex align-items-center">
            <i class="bi bi-arrow-left me-2 fs-5"></i>
            <span class="fw-medium">Home</span>
        </a>
        <span class="fw-bold text-dark">Profil Saya</span>
    </div>

    <div class="container py-4 py-md-5 mt-5 mt-md-0" style="min-height: 100vh; max-width: 1024px;">

        <div class="d-none d-md-block mb-4">
            <a href="/" class="text-decoration-none text-secondary d-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i>
                <span class="fw-medium small">Kembali ke Beranda</span>
            </a>
        </div>

        <h1 class="h3 fw-bold mb-4 d-none d-md-block text-secondary">Akun Saya</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">

                        <div
                            class="d-flex flex-row flex-md-column align-items-center text-md-center mb-4 position-relative">
                            <div class="flex-shrink-0 mb-md-3 me-3 me-md-0 border border-2 border-white shadow-sm rounded-circle overflow-hidden"
                                style="width: 80px; height: 80px;">
                                @if($customer->foto)
                                    <img src="{{ asset('uploads/' . $customer->foto) }}" alt="Avatar" class="avatar-img">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->nama_lengkap) }}&background=374151&color=fff&size=128"
                                        alt="Avatar" class="avatar-img">
                                @endif
                            </div>

                            <div class="flex-grow-1 w-100">
                                <h2 class="h5 fw-bold text-dark mb-0">{{ $customer->nama_lengkap }}</h2>
                                <p class="text-muted small text-truncate mb-0">{{ $customer->email }}</p>
                                <p class="text-muted small mb-0">{{ $customer->no_telp ?? '-' }}</p>
                            </div>

                            <button class="btn btn-link text-secondary p-0 position-absolute top-0 end-0 d-md-none"
                                onclick="triggerTab('v-pills-edit-tab')">
                                <i class="bi bi-pencil-square fs-5"></i>
                                <span class="d-block" style="font-size: 10px;">Edit</span>
                            </button>
                        </div>

                        <button
                            class="btn btn-custom-green w-100 mb-4 d-none d-md-block py-2 fw-medium btn-sm shadow-sm"
                            onclick="triggerTab('v-pills-edit-tab')">
                            Edit Data Diri
                        </button>

                        <hr class="d-none d-md-block text-secondary opacity-25 mb-4">

                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">

                            <button class="nav-link active mb-2" id="v-pills-history-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-history" type="button" role="tab">
                                <div class="icon-box"><i class="bi bi-clock-history small"></i></div>
                                <span class="small">Riwayat Pesanan</span>
                            </button>

                            <button class="nav-link mb-2" id="v-pills-address-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-address" type="button" role="tab">
                                <div class="icon-box"><i class="bi bi-geo-alt small"></i></div>
                                <span class="small">Alamat</span>
                            </button>

                            <button class="nav-link mb-2" id="v-pills-security-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-security" type="button" role="tab">
                                <div class="icon-box"><i class="bi bi-shield-lock small"></i></div>
                                <span class="small">Keamanan & akun</span>
                            </button>

                            <button class="nav-link d-none" id="v-pills-edit-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-edit" type="button" role="tab">
                                Edit
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="tab-content" id="v-pills-tabContent" style="min-height: 400px;">

                    <div class="tab-pane fade" id="v-pills-edit" role="tabpanel">
                        @include('components.profile.data-diri')
                    </div>

                    <div class="tab-pane fade show active" id="v-pills-history" role="tabpanel">
                        @include('components.profile.history')
                    </div>

                    <div class="tab-pane fade" id="v-pills-address" role="tabpanel">
                        @include('components.profile.alamat')
                    </div>

                    <div class="tab-pane fade" id="v-pills-security" role="tabpanel">
                        @include('components.profile.keamanan-akun')
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function triggerTab(tabId) {
            const triggerEl = document.querySelector('#' + tabId)
            const tab = new bootstrap.Tab(triggerEl)
            tab.show()
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>