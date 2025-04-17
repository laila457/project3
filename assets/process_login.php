<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing credentials']);
        exit();
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'index.php';

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        exit();
    }

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo json_encode(['status' => 'success', 'redirect' => $redirect]);
            exit();
        }
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    exit();
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
?>