<?php
require '../register/db.php';

header('Content-Type: application/json');

// Get user ID from request
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id > 0) {
    // Fetch user data
    $stmt = $conn->prepare("SELECT full_name, phone_number, email, dealer_name, state, lga, address, nin FROM users WHERE unique_code = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(["error" => "User not found"]);
    }
} else {
    echo json_encode(["error" => "Invalid user ID"]);
}
?>
