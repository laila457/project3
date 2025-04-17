<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="banner-container">
        <img src="./image/logooo.png" alt="Pet Banner" class="banner-image" />
        <div class="login-wrapper">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-light login-button">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            <?php else: ?>
                <a href="login.php" class="btn btn-light login-button">
                    <i class="bi bi-person-circle"></i> Login
                </a>
            <?php endif; ?>
        </div>
    </div>
    <nav>
        <a href="index.php"><i class="bi bi-house-door"></i> Beranda</a>
        <a href="layanan.php"><i class="bi bi-grid"></i> Layanan</a>
        <a href="booking.php"><i class="bi bi-calendar-check"></i> Grooming</a>
        <a href="boarding.php"><i class="bi bi-house"></i> Penitipan</a>
        <a href="akun.php"><i class="bi bi-person"></i> Akun</a>
    </nav>

    <div class="container mt-5">
        <div class="text-center mb-5">
            <h2 class="display-4 mb-3">Layanan Kami</h2>
            <p class="lead">Pilih layanan terbaik untuk hewan kesayangan Anda</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="service-card">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="./image/grooming.png" alt="Grooming" class="card-img-top p-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Grooming</h5>
                            <p class="card-text text-muted mb-3">Mulai dari Rp 60.000</p>
                            <a href="booking.php" class="btn btn-primary">
                                <i class="bi bi-calendar-plus"></i> Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="./image/penitipan.png" alt="Penitipan" class="card-img-top p-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Penitipan</h5>
                            <p class="card-text text-muted mb-3">Mulai dari Rp 50.000/hari</p>
                            <a href="boarding.php" class="btn btn-primary">
                                <i class="bi bi-calendar-plus"></i> Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="./image/antar.png" alt="Antar Jemput" class="card-img-top p-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Antar Jemput</h5>
                            <p class="card-text text-muted mb-3">Tersedia untuk area tertentu</p>
                            <a href="booking.php" class="btn btn-primary">
                                <i class="bi bi-calendar-plus"></i> Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body p-4">
                <h3 class="card-title mb-4"><i class="bi bi-info-circle"></i> Syarat dan Ketentuan</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                            <p class="mb-0">Hewan harus dalam kondisi sehat dan tidak agresif</p>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                            <p class="mb-0">Tidak menerima hewan dengan penyakit menular</p>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                            <p class="mb-0">Jika hewan sulit dikendalikan, biaya tambahan dapat dikenakan</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                            <p class="mb-0">Pembatalan kurang dari 24 jam sebelum jadwal tidak bisa refund</p>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                            <p class="mb-0">Untuk layanan penitipan, hewan wajib sudah divaksin</p>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                            <p class="mb-0">Layanan antar jemput hanya tersedia di area tertentu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-5">
            <a href="booking.php" class="btn btn-primary btn-lg">
                <i class="bi bi-calendar-plus"></i> Pesan Grooming
            </a>
            <a href="boarding.php" class="btn btn-primary btn-lg ms-2">
                <i class="bi bi-calendar-plus"></i> Pesan Penitipan
            </a>
        </div>
    </div>

    <footer class="mt-5">
        <div class="container">
            <p class="m-0">&copy; 2025 HappyPaws Indo. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
