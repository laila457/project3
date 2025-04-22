<?php
session_start();
require_once '../config/connection.php';
require_once 'config.php';

// Handle direct payment after booking
if (isset($_SESSION['new_booking_id'])) {
    $booking_id = $_SESSION['new_booking_id'];
    unset($_SESSION['new_booking_id']); // Clear the session variable
} else if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
} else {
    header("Location: booking.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $payment_method = $_POST['payment_method'];
    
    // Handle file upload
    $target_dir = "payment_proofs/";
    $file_extension = strtolower(pathinfo($_FILES["payment_proof"]["name"], PATHINFO_EXTENSION));
    $new_filename = "payment_" . $booking_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
        // Update booking with payment info
        $stmt = $conn->prepare("UPDATE bookings SET payment_method = ?, payment_proof = ?, payment_status = 'paid' WHERE id = ?");
        $stmt->bind_param("ssi", $payment_method, $new_filename, $booking_id);
        
        if ($stmt->execute()) {
            header("Location: payment_success.php");
            exit();
        }
    }
    
    // If we get here, something went wrong
    header("Location: payment.php?booking_id=" . $booking_id . "&error=1");
    exit();
}
?>