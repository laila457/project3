<?php
header("Content-Type: application/json");
require_once '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        echo json_encode(["status" => "error", "message" => "All fields are required!"]);
        exit();
    }

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    try {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Check existing user
        $checkUser = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $checkUser->bind_param("ss", $username, $email);
        $checkUser->execute();
        $result = $checkUser->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Username or email already exists!"]);
            exit();
        }

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Registration successful!"]);
        } else {
            throw new Exception("Registration failed");
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method!"]);
}
?>