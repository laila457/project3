<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO pet_boarding (
            owner_name, phone, pet_name, pet_type, 
            check_in_date, check_out_date, package,
            special_notes, delivery_method, kecamatan, 
            desa, detail_alamat
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("ssssssssssss",
            $_POST['owner_name'],
            $_POST['phone'],
            $_POST['pet_name'],
            $_POST['pet_type'],
            $_POST['check_in_date'],
            $_POST['check_out_date'],
            $_POST['package'],
            $_POST['special_notes'],
            $_POST['delivery_method'],
            $_POST['kecamatan'],
            $_POST['desa'],
            $_POST['detail_alamat']
        );

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to success page
            header("Location: booking_success.php?type=boarding");
            exit();
        } else {
            throw new Exception("Error processing booking");
        }

    } catch (Exception $e) {
        // Redirect to error page
        header("Location: boarding.php?error=1");
        exit();
    }
}
?>