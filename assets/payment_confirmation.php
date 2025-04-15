<?php
session_start();
require_once '../config/connection.php';

if (!isset($_GET['booking_id'])) {
    header("Location: booking.php");
    exit();
}

$booking_id = $_GET['booking_id'];

// Fetch booking details
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    header("Location: booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - Happy Paws</title>
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
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Konfirmasi Pembayaran</h2>
                        
                        <div class="alert alert-success text-center mb-4">
                            <i class="bi bi-check-circle-fill fs-1 d-block mb-3"></i>
                            <h4>Booking Berhasil!</h4>
                            <p class="mb-0">Silakan lakukan pembayaran sesuai metode yang dipilih</p>
                        </div>

                        <div class="payment-details mb-4">
                            <h5>Instruksi Pembayaran <?php echo htmlspecialchars($booking['payment_method']); ?>:</h5>
                            <?php if($booking['payment_method'] == 'BCA'): ?>
                                <div class="alert alert-info">
                                    <p><strong>Nomor Rekening:</strong> 1234567890</p>
                                    <p><strong>Atas Nama:</strong> Happy Paws</p>
                                    <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($booking['total_payment'], 0, ',', '.'); ?></p>
                                </div>
                            <?php elseif($booking['payment_method'] == 'Mandiri'): ?>
                                <div class="alert alert-info">
                                    <p><strong>Nomor Rekening:</strong> 0987654321</p>
                                    <p><strong>Atas Nama:</strong> Happy Paws</p>
                                    <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($booking['total_payment'], 0, ',', '.'); ?></p>
                                </div>
                            <?php elseif($booking['payment_method'] == 'DANA'): ?>
                                <div class="alert alert-info">
                                    <p><strong>Nomor DANA:</strong> 081234567890</p>
                                    <p><strong>Atas Nama:</strong> Happy Paws</p>
                                    <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($booking['total_payment'], 0, ',', '.'); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="payment-steps">
                            <h5>Langkah Selanjutnya:</h5>
                            <ol class="list-group list-group-numbered mb-4">
                                <li class="list-group-item">Transfer sesuai nominal yang tertera</li>
                                <li class="list-group-item">Simpan bukti pembayaran</li>
                                <li class="list-group-item">Kirim bukti pembayaran ke WhatsApp 081234567890</li>
                            </ol>
                        </div>

                        <div class="text-center">
                            <a href="index.php" class="btn btn-primary">
                                <i class="bi bi-house-door"></i> Kembali ke Beranda
                            </a>
                        </div>
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