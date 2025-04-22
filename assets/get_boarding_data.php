<?php
session_start();
require_once '../config/connection.php';

if(isset($_GET['rebooking_id'])) {
    $booking_id = $_GET['rebooking_id'];
    
    $stmt = $conn->prepare("SELECT owner_name, phone, pet_name, pet_type, package, special_notes FROM boardings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $boarding_data = $result->fetch_assoc();
    
    echo json_encode($boarding_data);
}
?>