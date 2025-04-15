<?php
require_once 'config.php';

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

// Calculate total payment
$base_price = str_replace(['Basic - ', 'Kutu - Jamur - ', 'Full - ', 'k'], '', $booking['package']);
$delivery_cost = ($booking['delivery_method'] === 'antar_jemput') ? 20 : 0;
$total_price = ($base_price + $delivery_cost) * 1000;

// Update the total price in database
$update_stmt = $conn->prepare("UPDATE bookings SET total_payment = ? WHERE id = ?");
$update_stmt->bind_param("di", $total_price, $booking_id);
$update_stmt->execute();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Happy Paws</title>
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
                        <h2 class="text-center mb-4">Pembayaran Otomatis</h2>
                        
                        <div class="booking-details mb-4">
                            <h5>Detail Pesanan:</h5>
                            <p><strong>Paket:</strong> <?php echo htmlspecialchars($booking['package']); ?></p>
                            <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?></p>
                            <p><strong>Waktu:</strong> <?php echo htmlspecialchars($booking['booking_time']); ?></p>
                            <?php if ($booking['delivery_method'] === 'antar_jemput'): ?>
                                <p><strong>Biaya Antar Jemput:</strong> Rp 20.000</p>
                            <?php endif; ?>
                            <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($total_price, 0, ',', '.'); ?></p>
                        </div>

                        <div class="payment-methods">
                            <h5 class="mb-3">Pilih Metode Pembayaran:</h5>
                            <form action="process_payment.php" method="POST">
                                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                                <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
                                
                                <div class="mb-3">
                                    <select class="form-select" name="payment_method" required>
                                        <option value="">Pilih metode pembayaran</option>
                                        <option value="BCA">Transfer Bank BCA</option>
                                        <option value="Mandiri">Transfer Bank Mandiri</option>
                                        <option value="DANA">DANA</option>
                                    </select>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-credit-card"></i> Bayar Sekarang
                                    </button>
                                </div>
                            </form>
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

    <script>
    function showPaymentDetails(method) {
        const detailsDiv = document.getElementById('paymentDetails');
        const instructionsDiv = document.getElementById('paymentInstructions');
        let instructions = '';

        switch(method) {
            case 'BCA':
                instructions = `
                    <p>Nomor Rekening: 1234567890</p>
                    <p>Atas Nama: Happy Paws</p>
                    <p>1. Transfer sesuai nominal yang tertera</p>
                    <p>2. Simpan bukti pembayaran</p>
                    <p>3. Kirim bukti pembayaran ke WhatsApp 081234567890</p>
                `;
                break;
            case 'Mandiri':
                instructions = `
                    <p>Nomor Rekening: 0987654321</p>
                    <p>Atas Nama: Happy Paws</p>
                    <p>1. Transfer sesuai nominal yang tertera</p>
                    <p>2. Simpan bukti pembayaran</p>
                    <p>3. Kirim bukti pembayaran ke WhatsApp 081234567890</p>
                `;
                break;
            case 'DANA':
                instructions = `
                    <p>Nomor DANA: 081234567890</p>
                    <p>Atas Nama: Happy Paws</p>
                    <p>1. Buka aplikasi DANA</p>
                    <p>2. Pilih "Kirim"</p>
                    <p>3. Masukkan nomor tujuan</p>
                    <p>4. Transfer sesuai nominal</p>
                    <p>5. Kirim bukti pembayaran ke WhatsApp 081234567890</p>
                `;
                break;
        }

        instructionsDiv.innerHTML = instructions;
        detailsDiv.style.display = 'block';
    }
    </script>
</body>
</html>