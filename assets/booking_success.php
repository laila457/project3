<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success - Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="banner-container">
        <img src="./image/logooo.png" alt="Pet Banner" class="banner-image" />
        <div class="login-wrapper">
            <a href="login.php" class="btn btn-light login-button">
                <i class="bi bi-person-circle"></i> Login
            </a>
        </div>
    </div>
    <nav>
        <a href="index.php"><i class="bi bi-house-door"></i> Beranda</a>
        <a href="layanan.php"><i class="bi bi-grid"></i> Layanan</a>
        <a href="booking.php"><i class="bi bi-calendar-check"></i> Booking</a>
        <a href="akun.php"><i class="bi bi-person"></i> Akun</a>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5 text-center">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <h2 class="mt-4 mb-3">Booking Berhasil!</h2>
                        <p class="mb-4">Terima kasih telah melakukan reservasi di Happy Paws. Kami akan menghubungi Anda untuk konfirmasi lebih lanjut.</p>
                        <a href="index.php" class="btn btn-primary">
                            <i class="bi bi-house-door"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5">
        <div class="container">
            <p class="m-0">&copy; 2025 HappyPaws Indo. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>