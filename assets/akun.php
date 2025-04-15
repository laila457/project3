<?php
session_start();
require_once '../config/connection.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun - Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="banner-container">
        <img src="./image/logooo.png" alt="Pet Banner" class="banner-image" />
    </div>
    <nav>
        <a href="index.php"><i class="bi bi-house-door"></i> Beranda</a>
        <a href="layanan.php"><i class="bi bi-grid"></i> Layanan</a>
        <a href="booking.php"><i class="bi bi-calendar-check"></i> Booking</a>
        <a href="akun.php" class="active"><i class="bi bi-person"></i> Akun</a>
    </nav>

    <div class="container mt-5">
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="row">
                <!-- Profile Card -->
                <div class="col-md-4 mb-4">
                    <div class="card profile-card">
                        <div class="card-body text-center">
                            <div class="profile-image-container mb-4">
                                <img src="./image/profile-default.png" alt="Profile" class="profile-image shadow">
                            </div>
                            <h4 class="mb-2"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></h4>
                            <p class="text-muted mb-3"><?= htmlspecialchars($_SESSION['email'] ?? 'email@example.com') ?></p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" onclick="location.href='edit_profile.php'">
                                    <i class="bi bi-pencil"></i> Edit Profile
                                </button>
                                <button class="btn btn-outline-danger" onclick="confirmLogout()">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking History -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Pemesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Layanan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($bookings) && $bookings->num_rows > 0): ?>
                                            <?php while($booking = $bookings->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= date('d M Y', strtotime($booking['booking_date'])) ?></td>
                                                    <td><?= htmlspecialchars($booking['service_type']) ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= $booking['status'] == 'completed' ? 'success' : 'warning' ?>">
                                                            <?= ucfirst($booking['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info">
                                                            <i class="bi bi-eye"></i> Detail
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
                                                    <p class="text-muted mb-3">Belum ada riwayat pemesanan</p>
                                                    <a href="booking.php" class="btn btn-primary">
                                                        <i class="bi bi-plus-circle"></i> Buat Pemesanan
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-lock display-1 text-muted mb-3"></i>
                    <h4>Silakan Login</h4>
                    <p class="text-muted mb-4">Untuk melihat informasi akun Anda</p>
                    <a href="login.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function confirmLogout() {
        if(confirm('Apakah Anda yakin ingin keluar?')) {
            window.location.href = 'logout.php';
        }
    }
    </script>

    <footer class="mt-5">
        <p>&copy; 2025 HappyPaws Indo. All Rights Reserved.</p>
    </footer>
</body>
</html>