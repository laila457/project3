<?php
session_start();
require_once '../config/connection.php';

if(isset($_GET['rebooking_id'])) {
    $booking_id = $_GET['rebooking_id'];
    
    $stmt = $conn->prepare("SELECT owner_name, phone, pet_type, package FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking_data = $result->fetch_assoc();
    
    echo json_encode($booking_data);
}
?>