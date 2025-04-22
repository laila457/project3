<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Include your navigation here -->
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <h2 class="mt-4">Terima Kasih!</h2>
                        <p class="lead">Pembayaran Anda telah berhasil dikonfirmasi.</p>
                        <p>Tim kami akan segera menghubungi Anda untuk konfirmasi jadwal grooming.</p>
                        <div class="mt-4">
                            <a href="index.php" class="btn btn-primary btn-lg">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>