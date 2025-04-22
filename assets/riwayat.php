<?php
session_start();
require_once '../config/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get bookings for the logged-in user
$query = "SELECT b.*, 
          CASE 
            WHEN b.payment_status = 'paid' OR (b.payment_proof IS NOT NULL AND b.payment_proof != '') THEN 'Sudah Dibayar'
            ELSE 'Belum Dibayar'
          END as payment_status
          FROM bookings b 
          WHERE b.user_id = ?
          ORDER BY b.booking_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking</title>
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
        <a href="riwayat.php">Riwayat</a>
        <a href="akun.php">Akun</a>
    </nav>

    <div class="container mt-5">
        <h2>Riwayat Booking</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Nama</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($booking['booking_date'])) ?></td>
                            <td><?= $booking['booking_time'] ?></td>
                            <td><?= htmlspecialchars($booking['owner_name']) ?></td>
                            <td><?= htmlspecialchars($booking['package']) ?></td>
                            <td>
                                <span class="badge <?= $booking['payment_status'] == 'Sudah Dibayar' ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $booking['payment_status'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if($booking['payment_status'] == 'Belum Dibayar'): ?>
                                    <a href="payment.php?booking_id=<?= $booking['id'] ?>" 
                                       class="btn btn-primary btn-sm">Bayar</a>
                                <?php else: ?>
                                    <div class="btn-group">
                                        <a href="receipt.php?booking_id=<?= $booking['id'] ?>" 
                                           class="btn btn-info btn-sm">Lihat Struk</a>
                                        <a href="booking.php?rebooking_id=<?= $booking['id'] ?>" 
                                           class="btn btn-success btn-sm">Pesan Lagi</a>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Belum ada riwayat booking. <a href="booking.php" class="alert-link">Buat booking baru</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>