<?php
require '../register/db.php';
// header('Content-Type: application/json');

$user = null;
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $unique_code = trim($_GET['uuid']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE unique_code = ?");
    $stmt->bind_param("s", $unique_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $error = "Invalid Unique Code. Please check and try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   

    <div id="badge" class="badge">
        <div class="badge-header">
            <img src="../assets/images/amdon_logo_main.jpg" style="max-width: 200px;">
            <!-- <h1 id="badgeEvent">Yootify</h1> -->
        </div>
        <div class="badge-body">
            <h2 id="badgeName"><?=$user['full_name']; ?></h2>
            <p id="badgeDesignation"><?=$user['dealer_name']; ?> (CEO)</p>
            <p id="badgeDesignation">Member ID: AMD-OY-<?=$user['id']; ?></p>
        </div>
        <div id="qrcode" class="badge-qr">
        </div>
        <h3 id="badgecontainer">Address: <?=$user['address']; ?>.</h3><br>
        <div class="badge-footer">
            <p id="badgeAccess">Oyo State AMDON Member</p>
        </div>
    </div>
        <input type="hidden"  name="uuid" value="<?=$unique_code; ?>" id="uuid" readonly style="height: 50px;">

    <button id="dwnBadge" class="dwnBadge">Download Badge</button>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.js"></script>
    <script src="script.js"></script>
</body>
</html>