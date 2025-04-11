<?php
session_start();
require_once '../config/connection.php';

if (!isset($_GET['payment_id'])) {
    header("Location: booking.php");
    exit();
}

$payment_id = $_GET['payment_id'];
$query = "SELECT p.*, b.booking_date, b.booking_time, b.package, b.owner_name, b.phone, b.pet_type, b.total_pets, b.address
          FROM payments p 
          JOIN bookings b ON p.booking_id = b.id 
          WHERE p.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();

// Redirect if payment not found
if (!$payment) {
    $_SESSION['error'] = "Payment data not found.";
    header("Location: booking.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        @media print {
            body {
                width: 80mm;
                margin: 0 auto;
            }
            .no-print {
                display: none;
            }
        }
        .receipt-container {
            max-width: 80mm;
            margin: 0 auto;
            padding: 10px;
            font-size: 14px;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header img {
            max-width: 60mm;
            height: auto;
        }
        .receipt-details {
            margin: 10px 0;
        }
        .receipt-line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <img src="./image/logooo.png" alt="Happy Paws">
            <h4>Happy Paws</h4>
            <p>Pet Grooming & Care</p>
        </div>

        <div class="receipt-line"></div>

        <div class="receipt-details">
            <p>No: <?= str_pad($payment_id, 6, '0', STR_PAD_LEFT) ?></p>
            <p>Tanggal: <?= isset($payment['payment_date']) ? date('d/m/Y H:i', strtotime($payment['payment_date'])) : '-' ?></p>
        </div>

        <div class="receipt-line"></div>

        <div class="receipt-details">
            <p>Nama: <?= htmlspecialchars($payment['owner_name'] ?? '-') ?></p>
            <p>No. HP: <?= htmlspecialchars($payment['phone'] ?? '-') ?></p>
            <p>Alamat: <?= htmlspecialchars($payment['address'] ?? '-') ?></p>
        </div>

        <div class="receipt-line"></div>

        <div class="receipt-details">
            <p>Jenis Hewan: <?= htmlspecialchars($payment['pet_type'] ?? '-') ?></p>
            <p>Jumlah: <?= htmlspecialchars($payment['total_pets'] ?? '-') ?></p>
            <p>Paket: <?= htmlspecialchars($payment['package'] ?? '-') ?></p>
            <p>Tanggal: <?= isset($payment['booking_date']) ? date('d/m/Y', strtotime($payment['booking_date'])) : '-' ?></p>
            <p>Jam: <?= htmlspecialchars($payment['booking_time'] ?? '-') ?></p>
        </div>

        <div class="receipt-line"></div>

        <div class="receipt-details">
            <p><strong>Total: Rp <?= number_format($payment['amount'] ?? 0, 0, ',', '.') ?></strong></p>
            <p>Metode: <?= ucfirst(htmlspecialchars($payment['payment_method'] ?? '-')) ?></p>
        </div>

        <div class="receipt-line"></div>

        <div class="receipt-footer">
            <p>Terima kasih telah mempercayakan<br>hewan kesayangan Anda kepada kami</p>
            <p>www.happypaws.com</p>
        </div>

        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>