<?php
session_start();
require_once '../config/connection.php';

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
                        <td><?= $booking['payment_status'] ?></td>
                        <td>
                            <?php if($booking['payment_status'] == 'Belum Dibayar'): ?>
                                <a href="payment.php?booking_id=<?= $booking['id'] ?>" 
                                   class="btn btn-primary btn-sm">Bayar</a>
                            <?php else: ?>
                                <a href="receipt.php?payment_id=<?= $booking['id'] ?>" 
                                   class="btn btn-info btn-sm">Lihat Struk</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>