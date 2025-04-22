<?php
session_start();
require_once '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $owner_name = $_POST['owner_name'];
    $phone = $_POST['phone'];
    $pet_name = $_POST['pet_name'];
    $pet_type = $_POST['pet_type'];
    $package = $_POST['package'];
    $special_notes = $_POST['special_notes'];
    $delivery_method = $_POST['delivery_method'];
    
    // Initialize address fields
    $kecamatan = $desa = $detail_alamat = null;
    $delivery_cost = 0;
    
    // If delivery method is antar_jemput, get address details and calculate delivery cost
    if ($delivery_method === 'antar_jemput') {
        $kecamatan = $_POST['kecamatan'];
        $desa = $_POST['desa'];
        $detail_alamat = $_POST['detail_alamat'];
        
        $allowed_locations = [
            'Lowokwaru' => [
                'Tunggulwulung' => 20000,
                'Tlogomas' => 20000,
                'Merjosari' => 20000,
                'Dinoyo' => 20000,
                'Sumbersari' => 20000
            ]
        ];

        if (isset($allowed_locations[$kecamatan]) && isset($allowed_locations[$kecamatan][$desa])) {
            $delivery_cost = $allowed_locations[$kecamatan][$desa];
        } else {
            die("Maaf, layanan antar jemput belum tersedia untuk lokasi Anda");
        }
    }

    // Calculate total price
    $base_price = str_replace(['Regular - ', 'Premium - ', 'k'], '', $_POST['package']);
    $total_price = ($base_price * 1000) + $delivery_cost;

    $sql = "INSERT INTO pet_boarding (check_in_date, check_out_date, owner_name, phone, pet_name, pet_type, package, special_notes, delivery_method, kecamatan, desa, detail_alamat, delivery_cost, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'ssssssssssssdd',
        $check_in_date,
        $check_out_date,
        $owner_name,
        $phone,
        $pet_name,
        $pet_type,
        $package,
        $special_notes,
        $delivery_method,
        $kecamatan,
        $desa,
        $detail_alamat,
        $delivery_cost,
        $total_price
    );

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        header("Location: payment.php?boarding_id=" . $booking_id);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>