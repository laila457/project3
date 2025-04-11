<?php
session_start();
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $payment_date = date('Y-m-d H:i:s');
    
    // Create payment record
    $query = "INSERT INTO payments (booking_id, amount, payment_method, payment_date) 
              VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("idss", $booking_id, $amount, $payment_method, $payment_date);
    
    if ($stmt->execute()) {
        header("Location: receipt.php?payment_id=" . $conn->insert_id);
    } else {
        header("Location: payment.php?booking_id=" . $booking_id);
    }
    exit();
}