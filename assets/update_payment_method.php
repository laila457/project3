<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("UPDATE bookings SET payment_method = ? WHERE id = ?");
    $stmt->bind_param("si", $payment_method, $booking_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>