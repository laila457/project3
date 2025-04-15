<?php
session_start();
require_once '../config/connection.php';
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $payment_method = $_POST['payment_method'];
    $total_amount = $_POST['total_amount'];

    // Update payment status in database
    $stmt = $conn->prepare("UPDATE bookings SET payment_status = 'pending', payment_method = ? WHERE id = ?");
    $stmt->bind_param("si", $payment_method, $booking_id);
    
    if ($stmt->execute()) {
        // Redirect to payment confirmation page
        header("Location: payment_confirmation.php?booking_id=" . $booking_id);
        exit();
    } else {
        echo "Error processing payment: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>