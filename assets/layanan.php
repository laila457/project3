<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Paws</title>
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
        <a href="akun.php">Akun</a>
    </nav>
    <button class="login-button" onclick="window.location.href='login.php'">
      Login
    </button>
    <div class="center-content">
      <a href="layanan.php" class="section-title">Layanan</a>
    </div>
    <div class="cards">
      <div class="card">
            <img src="./image/grooming.png" alt="Grooming">
            <h5>Grooming</h5>
            <p>Mulai dari 60.000</p>
            <a href="booking.php" class="booking-button">Book Now</a>
      </div>
      <div class="card">
            <img src="./image/penitipan.png" alt="Penitipan">
            <h5>Penitipan</h5>
            <p>Mulai dari 50.000/hari</p>
            <button class="booking-button" onclick="window.location.href='booking.php'">Booking Now</button>
      </div>
      <div class="card">
            <img src="./image/antar.png" alt="Antar Jemput">
            <h5>Antar Jemput</h5>
            <div class="spacer"></div>
      </div>
    </div>
    <div class="container-syarat">
      <h3>Syarat dan Ketentuan</h3>
      <p>🔹 Hewan harus dalam kondisi sehat dan tidak agresif.</p>
      <p>🔹 Tidak menerima hewan dengan penyakit menular.</p>
      <p>🔹 Jika hewan sulit dikendalikan, biaya tambahan dapat dikenakan.</p>
      <p>🔹 Pembatalan kurang dari 24 jam sebelum jadwal tidak bisa refund.</p>
      <p>🔹 Untuk layanan penitipan, hewan wajib sudah divaksin.</p>
      <p>🔹 Layanan antar jemput hanya tersedia di area tertentu dan sesuai jadwal yang disepakati.</p>
    </div>
    <button class="btn-order">Pesan Sekarang</button>
    <footer>
      <p>&copy; 2025 HappyPaws Indo. All Rights Reserved.</p>
    </footer>
  </body>
</html>
