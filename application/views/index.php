<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/style.css">

</head>
<body>
    <div class="banner-container">
      <img src="<?=base_url();?>assets/image/logooo.png" alt="Pet Banner" class="banner-image" />
    </div>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="assets/layanan.php">Layanan</a>
        <a href="booking.php">Booking</a>
        <a href="akun.php">Akun</a>
    </nav>
    <button class="login-button" onclick="window.location.href='<?=site_url('index/login');?>'">
      Login
    </button>
    <div class="container">
      <h3>Welcome to Happy Paws</h3>
      <p>Setiap hewan memiliki kebutuhan unik, itulah mengapa Happy Paws hadir 
        untuk memberikan pengalaman perawatan yang menyenangkan dan bebas stres bagi hewan kesayangan Anda.</p>
      </div>
    <div class="center-content">
      <a href="assets/layanan.php" class="section-title">Layanan</a>
    </div>
    <div class="cards">
        <div class="card">
            <a href="<?=site_url('index/layanan');?>">
            <img src="<?=base_url();?>assets/image/grooming.png" alt="Grooming">
            <h5>Grooming</h5>
        </div>
        <div class="card">
            <a href="assets/layanan.php">
            <img src="<?=base_url();?>assets/image/penitipan.png" alt="Penitipan">
            <h5>Penitipan</h5>
        </div>
        <div class="card">
            <a href="assets/layanan.php">
            <img src="<?=base_url();?>assets/image/antar.png" alt="Antar Jemput">
            <h5>Antar Jemput</h5>
        </div>
    </div>

    <button class="btn-order" onclick="window.location.href='assets/layanan.php'">Pesan Sekarang</button>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <footer>
      <p>&copy; 2025 HappyPaws Indo. All Rights Reserved.</p>
    </footer>
</body>
</html>
