<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $owner_name = $_POST['owner_name'];
    $phone = $_POST['phone'];
    $pet_type = $_POST['pet_type'];
    $package = $_POST['package'];
    $delivery_method = $_POST['delivery_method'];
    
    // Initialize address fields
    $kecamatan = $desa = $address = null;
    
    // If delivery method is antar_jemput, get address details
    if ($delivery_method === 'antar_jemput') {
        $kecamatan = $_POST['kecamatan'];
        $desa = $_POST['desa'];
        $address = $_POST['detail_alamat'];
    }

    $sql = "INSERT INTO bookings (booking_date, booking_time, owner_name, phone, pet_type, package, delivery_method, kecamatan, desa, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'ssssssssss',
        $booking_date,
        $booking_time,
        $owner_name,
        $phone,
        $pet_type,
        $package,
        $delivery_method,
        $kecamatan,
        $desa,
        $address
    );

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        header("Location: payment.php?booking_id=" . $booking_id);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>