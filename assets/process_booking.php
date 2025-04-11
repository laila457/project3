<?php
session_start();
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $owner_name = $_POST['owner_name'];
    $phone = $_POST['phone'];
    $pet_type = $_POST['pet_type'];
    $package = $_POST['package'];
    // Remove total_pets variable and from the query
    $query = "INSERT INTO bookings (booking_date, booking_time, owner_name, phone, pet_type, package, 
              delivery_method, address, kecamatan, desa) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssss", $booking_date, $booking_time, $owner_name, $phone, $pet_type, $total_pets, 
                      $package, $delivery_method, $full_address, $kecamatan, $desa);
    
    if ($stmt->execute()) {
        $booking_id = $conn->insert_id;
        header("Location: payment.php?booking_id=" . $booking_id);
    } else {
        $_SESSION['error'] = "Gagal membuat booking.";
        header("Location: booking.php");
    }
    exit();
}
?>