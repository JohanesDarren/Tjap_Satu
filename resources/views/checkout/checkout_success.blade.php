<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Toko Kopi Tjap Satu</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f9fafb; 
            color: #1f2937; 
        }
        
        /* Warna Hijau Brand Kamu */
        .text-custom-green { color: #325B56; }
        .btn-custom-green { background-color: #325B56; color: white; border: none; }
        .btn-custom-green:hover { background-color: #264541; color: white; }
        
        /* Animasi Sederhana untuk Icon (Opsional, biar keren) */
        .success-icon {
            animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        @keyframes popIn {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center px-4" style="max-width: 500px;">
            
            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-custom-green success-icon" style="font-size: 5rem;"></i>
            </div>

            <h2 class="fw-bold mb-3 text-dark">Pembayaran Berhasil!</h2>
            
            <p class="text-secondary mb-5">
                Terima kasih, pesananmu sudah kami terima.<br>
                Mohon tunggu, kami sedang menyiapkan kopimu dengan penuh cinta.
            </p>
            
            <div class="d-grid gap-3 d-sm-flex justify-content-center">
                <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-medium rounded-3">
                    Lihat Pesanan
                </a>
                
                <a href="/menu" class="btn btn-custom-green px-4 py-2 fw-bold rounded-3 shadow-sm">
                    Belanja Lagi
                </a>
            </div>

        </div>
    </div>

</body>
</html>