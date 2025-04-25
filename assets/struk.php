<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['booking_id'])) {
    header('Location: index.php');
    exit();
}

$query = "SELECT b.*, 
          CASE 
            WHEN b.package LIKE '%Basic%' AND b.package NOT LIKE '%Boarding%' THEN 59000
            WHEN b.package LIKE '%Kutu%' OR b.package LIKE '%Jamur%' THEN 70000
            WHEN b.package LIKE '%Full%' THEN 86000
            WHEN b.package LIKE '%Regular%' THEN 50000
            WHEN b.package LIKE '%Premium%' THEN 75000
            ELSE 0
          END as price
          FROM bookings b 
          WHERE b.id = ? AND b.owner_name = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("is", $_GET['booking_id'], $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    header('Location: index.php');
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="./image/logooo.png" alt="Happy Paws Logo" style="max-height: 100px;">
                            <h2 class="mt-3">Struk Pembayaran</h2>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <p class="mb-1"><strong>No. Booking:</strong> #<?= $booking['id'] ?></p>
                                <p class="mb-1"><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($booking['booking_date'])) ?></p>
                                <p class="mb-1"><strong>Waktu:</strong> <?= $booking['booking_time'] ?></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-1"><strong>Nama:</strong> <?= htmlspecialchars($booking['owner_name']) ?></p>
                                <p class="mb-1"><strong>No. HP:</strong> <?= htmlspecialchars($booking['phone']) ?></p>
                                <p class="mb-1"><strong>Alamat:</strong> <?= htmlspecialchars($booking['address']) ?></p>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Layanan</th>
                                    <th>Jenis Hewan</th>
                                    <th class="text-end">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= htmlspecialchars($booking['package']) ?></td>
                                    <td><?= htmlspecialchars($booking['pet_type']) ?></td>
                                    <td class="text-end">Rp <?= number_format($booking['price'], 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end">Total</th>
                                    <th class="text-end">Rp <?= number_format($booking['price'], 0, ',', '.') ?></th>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="border-top pt-4 mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Status Pembayaran</h5>
                                    <p class="badge bg-success">Sudah Dibayar</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button onclick="window.print()" class="btn btn-primary">
                                        <i class="bi bi-printer"></i> Cetak Struk
                                    </button>
                                    <a href="index.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>