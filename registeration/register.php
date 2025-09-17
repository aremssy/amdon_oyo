<?php
require 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $dealer_name = $_POST['dealer_name'];
    $state = $_POST['state'];
    $lga = $_POST['lga'];
    $address = $_POST['address'];
    $nin = $_POST['nin'];
    $unique_code = strtoupper(substr(md5(time() . $email), 0, 10));

    $stmt = $conn->prepare("INSERT INTO users (full_name, phone_number, email, dealer_name, state, lga, address, nin, unique_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $full_name, $phone_number, $email, $dealer_name, $state, $lga, $address, $nin, $unique_code);

    if ($stmt->execute()) {
        header('Location: index.php?user_id=' . $conn->insert_id);
    } else {
        echo "Error: " . $conn->error;
    }
}
?>