<?php
$host = "localhost";
$user = "root"; // Sesuaikan jika perlu
$password = ""; // Sesuaikan jika ada password
$database = "admin";

// Buat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari permintaan POST dan sanitasi
$booking_date = isset($_POST['booking_date']) ? trim($_POST['booking_date']) : '';
$booking_time = isset($_POST['booking_time']) ? trim($_POST['booking_time']) : '';
$owner_name = isset($_POST['owner_name']) ? trim($_POST['owner_name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$pet_type = isset($_POST['pet_type']) ? trim($_POST['pet_type']) : '';
$total_pets = isset($_POST['total_pets']) ? trim($_POST['total_pets']) : '';
$package = isset($_POST['package']) ? trim($_POST['package']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';

// Validasi input
if (empty($booking_date) || empty($booking_time) || empty($owner_name) || empty($phone) || empty($pet_type) || empty($total_pets) || empty($package) || empty($address)) {
    die("Semua field harus diisi.");
}

// Debugging: Output the values being inserted
error_log("Booking Date: " . $booking_date);
error_log("Booking Time: " . $booking_time);
error_log("Owner Name: " . $owner_name);
error_log("Phone: " . $phone);
error_log("Pet Type: " . $pet_type);
error_log("Total Pets: " . $total_pets);
error_log("Package: " . $package);
error_log("Address: " . $address);

// Siapkan pernyataan SQL
$sql = "INSERT INTO bookings (booking_date, booking_time, owner_name, phone, pet_type, total_pets, package, address) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Ikat parameter
$stmt->bind_param("ssssssss", $booking_date, $booking_time, $owner_name, $phone, $pet_type, $total_pets, $package, $address);

// Eksekusi pernyataan
if ($stmt->execute()) {
    echo "Booking berhasil!";
} else {
    echo "Error: " . $stmt->error; // Output error jika ada
}

// Tutup pernyataan dan koneksi
$stmt->close();
$conn->close();
?>