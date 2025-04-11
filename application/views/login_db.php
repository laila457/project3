<?php
session_start();
header('Content-Type: application/json');

$username = $_POST['username'];
$password = $_POST['password'];

// Lakukan validasi login di sini
if ($username === 'admin' && $password === 'password') { // Ganti dengan logika autentikasi yang sesuai
    $_SESSION['user'] = $username; // Simpan informasi pengguna di sesi
    echo json_encode(['status' => 'success', 'message' => 'Login berhasil!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Username atau password salah!']);
}
?>