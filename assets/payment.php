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

// Calculate total payment - remove delivery cost
$base_price = str_replace(['Basic - ', 'Kutu - Jamur - ', 'Full - ', 'k'], '', $booking['package']);
$total_price = $base_price * 1000;

// Update the total price in database
$update_stmt = $conn->prepare("UPDATE bookings SET total_payment = ? WHERE id = ?");
$update_stmt->bind_param("di", $total_price, $booking_id);
$update_stmt->execute();
// Update the form to include file upload
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
        <a href="booking.php"><i class="bi bi-calendar-check"></i> Grooming</a>
        <a href="boarding.php"><i class="bi bi-house"></i> Penitipan</a>
        <a href="akun.php"><i class="bi bi-person"></i> Akun</a>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Pembayaran</h2>
                        
                        <div class="booking-details mb-4">
                            <h5>Detail Pesanan:</h5>
                            <p><strong>Paket:</strong> <?php echo htmlspecialchars($booking['package']); ?></p>
                            <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?></p>
                            <p><strong>Waktu:</strong> <?php echo htmlspecialchars($booking['booking_time']); ?></p>
                            <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($total_price, 0, ',', '.'); ?></p>
                        </div>

                        <div class="payment-methods">
                            <form id="paymentForm" action="process_payment.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                                <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
                                
                                <div class="mb-4">
                                    <h5 class="mb-3">Pilih Metode Pembayaran:</h5>
                                    <select class="form-select" name="payment_method" id="paymentMethod" onchange="showPaymentDetails(this.value)" required>
                                        <option value="">Pilih metode pembayaran</option>
                                        <option value="QRIS">QRIS</option>
                                        <option value="BCA">Transfer Bank BCA</option>
                                        <option value="Mandiri">Transfer Bank Mandiri</option>
                                    </select>
                                </div>

                                <div id="paymentDetails" class="mt-4" style="display: none;">
                                    <div class="text-center mb-4">
                                        <div id="qrisCode" style="display: none;">
                                            <img src="./image/qris.png" alt="QRIS Code" style="max-width: 200px;" class="mb-3">
                                            <p class="text-muted">Scan QRIS code di atas menggunakan aplikasi e-wallet Anda</p>
                                        </div>
                                        <div id="bankDetails" style="display: none;">
                                            <div class="alert alert-info">
                                                <h6 class="bank-name mb-2"></h6>
                                                <p class="account-number mb-1"></p>
                                                <p class="account-name mb-0">A.n Happy Paws</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h5>Upload Bukti Pembayaran</h5>
                                        <input type="file" class="form-control" name="payment_proof" accept="image/*" required>
                                        <small class="text-muted">Format: JPG, PNG, atau JPEG (Max 2MB)</small>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            Konfirmasi Pembayaran
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function showPaymentDetails(method) {
        const detailsDiv = document.getElementById('paymentDetails');
        const qrisDiv = document.getElementById('qrisCode');
        const bankDiv = document.getElementById('bankDetails');
        const bankName = bankDiv.querySelector('.bank-name');
        const accountNumber = bankDiv.querySelector('.account-number');
        
        if (method) {
            detailsDiv.style.display = 'block';
            
            if (method === 'QRIS') {
                qrisDiv.style.display = 'block';
                bankDiv.style.display = 'none';
            } else {
                qrisDiv.style.display = 'none';
                bankDiv.style.display = 'block';
                
                if (method === 'BCA') {
                    bankName.textContent = 'Bank BCA';
                    accountNumber.textContent = 'No. Rekening: 1234567890';
                } else if (method === 'Mandiri') {
                    bankName.textContent = 'Bank Mandiri';
                    accountNumber.textContent = 'No. Rekening: 0987654321';
                }
            }
        } else {
            detailsDiv.style.display = 'none';
        }
    }
    </script>
</body>
</html>