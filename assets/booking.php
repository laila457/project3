<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=booking.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Happy Paws</title>
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
                        <h2 class="text-center mb-4">Reservasi Grooming</h2>
                        
                        <!-- Add this in the head section -->
                        <script src="js/booking.js" defer></script>
                        
                        <!-- Replace the monthSelector section with this -->
                        <div class="booking-section mb-4">
                            <h5 class="mb-3"><i class="bi bi-calendar3"></i> Pilih Jadwal</h5>
                            <select id="monthSelector" class="form-select mb-3" onchange="changeMonth()">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        
                            <div id="dateButtons" class="d-flex flex-wrap gap-2 mb-3"></div>
                        </div>

                        <form id="bookingForm" action="process_booking.php" method="POST" onsubmit="return validateBooking()">
                            <input type="hidden" id="booking_date" name="booking_date">

                            <div class="mb-4">
                                <label for="booking_time" class="form-label">Waktu Booking</label>
                                <input type="time" id="booking_time" name="booking_time" required class="form-control">
                            </div>

                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-person"></i> Data Pelanggan</h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="owner_name" placeholder="Nama Pemilik" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="phone" placeholder="No. HP" required>
                                </div>
                            </div>

                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-heart"></i> Jenis Hewan</h5>
                                <div class="d-flex gap-4">
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
                                <h5 class="mb-3"><i class="bi bi-tag"></i> Pilih Paket</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Basic - 59k', this)">
                                        <div class="package-content">
                                            <div class="package-name">Basic</div>
                                            <div class="package-price">Rp 59.000</div>
                                        </div>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Kutu - Jamur - 70k', this)">
                                        <div class="package-content">
                                            <div class="package-name">Kutu & Jamur</div>
                                            <div class="package-price">Rp 70.000</div>
                                        </div>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary package-btn" onclick="selectPackage('Full - 86k', this)">
                                        <div class="package-content">
                                            <div class="package-name">Full Service</div>
                                            <div class="package-price">Rp 86.000</div>
                                        </div>
                                    </button>
                                </div>
                                <input type="hidden" id="selected_package" name="package">
                            </div>

                            <div class="booking-section mb-4">
                                <h5 class="mb-3"><i class="bi bi-geo-alt"></i> Lokasi dan Pengantaran</h5>
                                <div class="d-flex gap-4 mb-3">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="datang_sendiri" name="delivery_method" value="datang_sendiri" checked onchange="toggleDeliveryOptions()">
                                        <label class="form-check-label" for="datang_sendiri">Datang Sendiri</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="antar_jemput" name="delivery_method" value="antar_jemput" onchange="toggleDeliveryOptions()">
                                        <label class="form-check-label" for="antar_jemput">Layanan Antar Jemput (Gratis)</label>
                                    </div>
                                </div>
                                <small class="text-muted mb-3 d-block">
                                    <i class="bi bi-info-circle"></i> Layanan antar jemput gratis tersedia untuk area: Sukaharja, Pinayungan, dan Puseurjaya
                                </small>

                                <div id="addressSection" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Kecamatan</label>
                                        <select class="form-select" id="kecamatan" name="kecamatan" onchange="updateDesa()" required>
                                            <option value="">Pilih Kecamatan</option>
                                            <option value="Telukjambe Timur">Telukjambe Timur</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Desa/Kelurahan</label>
                                        <select class="form-select" id="desa" name="desa" required>
                                            <option value="">Pilih Desa/Kelurahan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Detail Alamat</label>
                                        <textarea class="form-control" id="detail_alamat" name="detail_alamat" rows="3" placeholder="Masukkan detail alamat (nama jalan, nomor rumah, RT/RW)" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Selesaikan Pemesanan
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

    <script>
    // Add this after your existing JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const rebookingId = urlParams.get('rebooking_id');
        
        if(rebookingId) {
            fetch('get_booking_data.php?rebooking_id=' + rebookingId)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('input[name="owner_name"]').value = data.owner_name;
                    document.querySelector('input[name="phone"]').value = data.phone;
                    document.querySelector(`input[name="pet_type"][value="${data.pet_type}"]`).checked = true;
                    selectPackage(data.package, document.querySelector(`button[onclick*="${data.package}"]`));
                });
        }
    });
    </script>
</body>
</html>