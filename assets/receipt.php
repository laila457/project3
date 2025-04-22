<?php
session_start();
require_once '../config/connection.php';

if (!isset($_GET['booking_id'])) {
    header("Location: riwayat.php");
    exit();
}

$booking_id = $_GET['booking_id'];

$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking || !$booking['payment_proof']) {
    header("Location: riwayat.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Include your navigation here -->
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Struk Pembayaran</h3>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><strong>Nama:</strong> <?= htmlspecialchars($booking['owner_name']) ?></p>
                        <p><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($booking['booking_date'])) ?></p>
                        <p><strong>Waktu:</strong> <?= $booking['booking_time'] ?></p>
                        <p><strong>Paket:</strong> <?= htmlspecialchars($booking['package']) ?></p>
                        <p><strong>Total Pembayaran:</strong> Rp <?= number_format($booking['total_payment'], 0, ',', '.') ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Bukti Pembayaran:</h5>
                        <img src="payment_proofs/<?= htmlspecialchars($booking['payment_proof']) ?>" 
                             class="img-fluid" alt="Bukti Pembayaran">
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="riwayat.php" class="btn btn-secondary">Kembali</a>
                    <a href="booking.php?rebooking_id=<?= $booking['id'] ?>" 
                       class="btn btn-primary">Pesan Lagi</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>