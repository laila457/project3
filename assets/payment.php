<?php
session_start();
require_once '../config/connection.php';

if (!isset($_GET['booking_id'])) {
    header("Location: booking.php");
    exit();
}

$booking_id = $_GET['booking_id'];
$query = "SELECT b.* 
          FROM bookings b 
          WHERE b.id = ? AND NOT EXISTS (
              SELECT 1 FROM payments p WHERE p.booking_id = b.id
          )";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

// Redirect if booking not found or already paid
if (!$booking) {
    $_SESSION['error'] = "Booking tidak ditemukan atau sudah dibayar.";
    header("Location: riwayat.php");
    exit();
}

// Extract price from package string
preg_match('/(\d+)k/', $booking['package'], $matches);
$price = isset($matches[1]) ? $matches[1] * 1000 : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
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
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">Detail Pembayaran</h2>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Detail Booking</h5>
                        <p>Paket: <?= htmlspecialchars($booking['package']) ?></p>
                        <p>Tanggal: <?= date('d/m/Y', strtotime($booking['booking_date'])) ?></p>
                        <p>Jam: <?= $booking['booking_time'] ?></p>
                        <p>Total: Rp <?= number_format($price, 0, ',', '.') ?></p>

                        <form action="process_payment.php" method="POST">
                            <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                            <input type="hidden" name="amount" value="<?= $price ?>">
                            
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select class="form-control" name="payment_method" required>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="ewallet">E-Wallet</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Proses Pembayaran</button>
                            <a href="riwayat.php" class="btn btn-secondary mt-3">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>