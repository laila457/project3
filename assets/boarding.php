<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=boarding.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Boarding - Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="banner-container">
        <img src="./image/logooo.png" alt="Pet Banner" class="banner-image" />
        <div class="login-wrapper">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-light login-button">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            <?php else: ?>
                <a href="login.php" class="btn btn-light login-button">
                    <i class="bi bi-person-circle"></i> Login
                </a>
            <?php endif; ?>
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
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Reservasi Penitipan Hewan</h2>

                        <form id="boardingForm" action="process_boarding.php" method="POST">
                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-calendar"></i> Periode Penitipan</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="check_in_date" class="form-label">Tanggal Check-in</label>
                                        <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="check_out_date" class="form-label">Tanggal Check-out</label>
                                        <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-person"></i> Data Pemilik</h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="owner_name" placeholder="Nama Pemilik" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="phone" placeholder="No. HP" required>
                                </div>
                            </div>

                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-heart"></i> Data Hewan</h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="pet_name" placeholder="Nama Hewan" required>
                                </div>
                                <div class="d-flex gap-4 mb-3">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="dog" name="pet_type" value="Anjing" required>
                                        <label class="form-check-label" for="dog">Anjing</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="cat" name="pet_type" value="Kucing" required>
                                        <label class="form-check-label" for="cat">Kucing</label>
                                    </div>
                                </div>
                            </div>

                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-tag"></i> Paket Penitipan</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Regular - 50k', this)">
                                        <div class="package-content">
                                            <div class="package-name">Regular</div>
                                            <div class="package-price">Rp 50.000/hari</div>
                                            <small>Kandang standar, makan 2x</small>
                                        </div>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Premium - 75k', this)">
                                        <div class="package-content">
                                            <div class="package-name">Premium</div>
                                            <div class="package-price">Rp 75.000/hari</div>
                                            <small>Kandang besar, makan 3x, grooming</small>
                                        </div>
                                    </button>
                                </div>
                                <input type="hidden" id="selected_package" name="package">
                            </div>

                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-clipboard"></i> Catatan Khusus</h5>
                                <textarea class="form-control" name="special_notes" rows="3" 
                                    placeholder="Contoh: Jadwal makan, obat-obatan, atau kebiasaan khusus hewan"></textarea>
                            </div>

                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-geo-alt"></i> Pengantaran</h5>
                                <div class="d-flex gap-4 mb-3">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="datang_sendiri" name="delivery_method" value="datang_sendiri" checked onchange="toggleDeliveryOptions()">
                                        <label class="form-check-label" for="datang_sendiri">Datang Sendiri</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="antar_jemput" name="delivery_method" value="antar_jemput" onchange="toggleDeliveryOptions()">
                                        <label class="form-check-label" for="antar_jemput">Layanan Antar Jemput</label>
                                    </div>
                                </div>

                                <div id="addressSection" style="display: none;">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="kecamatan" placeholder="Kecamatan">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="desa" placeholder="Desa/Kelurahan">
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" name="detail_alamat" rows="2" 
                                            placeholder="Detail Alamat (Nama Jalan, RT/RW, No. Rumah)"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Buat Reservasi Penitipan
                                </button>
                            </div>
                        </form>
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

    <script src="js/boarding.js"></script>
</body>
</html>