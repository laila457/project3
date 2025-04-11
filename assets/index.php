<?php
session_start();
require_once '../config/connection.php';

// Get booking history
$query = "SELECT b.*, 
          CASE 
            WHEN p.id IS NOT NULL THEN 'Sudah Dibayar'
            ELSE 'Belum Dibayar'
          END as payment_status
          FROM bookings b 
          LEFT JOIN payments p ON b.id = p.booking_id 
          ORDER BY b.booking_date DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="banner-container">
      <img src="./image/logooo.png" alt="Pet Banner" class="banner-image" />
    </div>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="layanan.php">Layanan</a>
        <a href="booking.php">Booking</a>
        <a href="akun.php">Akun</a>
    </nav>
    <button class="login-button" onclick="window.location.href='login.php'">
      Login
    </button>
    <div class="container">
        <h3>Welcome to Happy Paws</h3>
        <p>Setiap hewan memiliki kebutuhan unik, itulah mengapa Happy Paws hadir 
            untuk memberikan pengalaman perawatan yang menyenangkan dan bebas stres bagi hewan kesayangan Anda.</p>
    </div>
    <div class="center-content">
      <a href="layanan.php" class="section-title">Layanan</a>
    </div>
    <div class="cards">
        <div class="card">
            <a href="layanan.php">
            <img src="./image/grooming.png" alt="Grooming">
            <h5>Grooming</h5>
        </div>
        <div class="card">
            <a href="layanan.php">
            <img src="./image/penitipan.png" alt="Penitipan">
            <h5>Penitipan</h5>
        </div>
        <div class="card">
            <a href="layanan.php">
            <img src="./image/antar.png" alt="Antar Jemput">
            <h5>Antar Jemput</h5>
        </div>
    </div>

    <button class="btn-order" onclick="window.location.href='layanan.php'">Pesan Sekarang</button>

    <div class="container-pesanan" style="display: flex; flex-direction: row; gap: 20px; overflow-x: auto; padding: 20px;">
        <?php while($booking = $result->fetch_assoc()) : ?>
            <div class="order-box" style="min-width: 300px; flex-shrink: 0;">
                <h3><?= htmlspecialchars($booking['package']); ?></h3>
                <p><?= date('d/m/Y', strtotime($booking['booking_date'])); ?> | <?= $booking['booking_time']; ?></p>
                <p>Status: <?= $booking['payment_status']; ?></p>
                <p><strong>Nama: <?= htmlspecialchars($booking['owner_name']); ?></strong></p>
                <p><?= htmlspecialchars($booking['pet_type']); ?></p>
                <?php if($booking['payment_status'] == 'Menunggu Pembayaran'): ?>
                    <a href="payment.php?booking_id=<?= $booking['id'] ?>" class="btn-order">Bayar Sekarang</a>
                <?php else: ?>
                    <a href="booking.php" class="btn-order">Pesan Ulang</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <footer>
        <p>&copy; 2025 HappyPaws Indo. All Rights Reserved.</p>
    </footer>
</body>
</html>
