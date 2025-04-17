<?php
session_start();
require_once '../config/connection.php';

// Get booking history only for logged-in user
$query = "SELECT b.*, 
          CASE 
            WHEN p.id IS NOT NULL THEN 'Sudah Dibayar'
            ELSE 'Belum Dibayar'
          END as payment_status
          FROM bookings b 
          LEFT JOIN payments p ON b.id = p.booking_id 
          WHERE b.owner_name = ?
          ORDER BY b.booking_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']); // Changed to use username
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Paws</title>
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
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="display-4 mb-3">Welcome to Happy Paws</h2>
                <p class="lead mb-5">Setiap hewan memiliki kebutuhan unik, itulah mengapa Happy Paws hadir 
                    untuk memberikan pengalaman perawatan yang menyenangkan dan bebas stres bagi hewan kesayangan Anda.</p>
            </div>
        </div>

        <div class="text-center mb-5">
            <h3 class="section-title">Layanan Kami</h3>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="service-card">
                    <a href="layanan.php" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="./image/grooming.png" alt="Grooming" class="card-img-top p-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Grooming</h5>
                                <p class="card-text text-muted">Perawatan lengkap untuk kebersihan hewan kesayangan Anda</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <a href="layanan.php" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="./image/penitipan.png" alt="Penitipan" class="card-img-top p-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Penitipan</h5>
                                <p class="card-text text-muted">Tempat nyaman untuk hewan kesayangan Anda</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <a href="layanan.php" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="./image/antar.png" alt="Antar Jemput" class="card-img-top p-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Antar Jemput</h5>
                                <p class="card-text text-muted">Layanan antar jemput untuk kenyamanan Anda</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mb-5">
            <a href="layanan.php" class="btn btn-primary btn-lg">
                <i class="bi bi-calendar-plus"></i> Pesan Sekarang
            </a>
        </div>

        <?php if($result->num_rows > 0): ?>
        <div class="recent-bookings mb-5">
            <h3 class="section-title text-center mb-4">Pemesanan Terbaru</h3>
            <div class="row g-4">
                <?php while($booking = $result->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($booking['package']); ?></h5>
                            <p class="card-text">
                                <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($booking['booking_date'])); ?><br>
                                <i class="bi bi-clock"></i> <?= $booking['booking_time']; ?><br>
                                <i class="bi bi-person"></i> <?= htmlspecialchars($booking['owner_name']); ?><br>
                                <i class="bi bi-tag"></i> <?= htmlspecialchars($booking['pet_type']); ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-<?= $booking['payment_status'] == 'Sudah Dibayar' ? 'success' : 'warning' ?>">
                                    <?= $booking['payment_status']; ?>
                                </span>
                                <?php if($booking['payment_status'] == 'Belum Dibayar'): ?>
                                    <a href="payment.php?booking_id=<?= $booking['id'] ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-credit-card"></i> Bayar
                                    </a>
                                <?php else: ?>
                                    <a href="booking.php" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> Pesan Lagi
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <footer class="mt-5">
        <div class="container">
            <p class="m-0">&copy; 2025 HappyPaws Indo. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
