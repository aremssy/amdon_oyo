<?php
require '../register/SuiteCRMClient.php'; // Your SuiteCRMClient PHP class

$user = null;
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['uuid'])) {
    $unique_code = trim($_GET['uuid']);
$selectFields = ['name', 'phone_office', 'id', 'ownership','address','email1','employees','rating','description'];
    // Instantiate and login SuiteCRM client
    $crmClient = new SuiteCRMClient();

    try {
        $crmClient->login();

        // Search the Amdon_Dealers module for record with matching unique_code
            $entry = $crmClient->getRecordById('AMD_Members', $unique_code, $selectFields);

        if ($entry) {
            $user = [];
            foreach ($entry as $field) {
                if ($field['name'] === 'name') {
                    $user['full_name'] = $field['value'];
                } elseif ($field['name'] === 'phone_office') {
                    $user['phone_number'] = $field['value'];
                } elseif ($field['name'] === 'ownership') {
                    $user['dealer_name'] = $field['value'];
                } elseif ($field['name'] === 'rating') {
                    $user['id'] = $field['value'];
                } elseif ($field['name'] === 'email1') {
                    $user['email'] = $field['value'];
                } elseif ($field['name'] === 'employees') {
                    $user['state'] = "Oyo State";
                } elseif ($field['name'] === 'employees') {
                    $user['lga'] = $field['value'];
                }elseif ($field['name'] === 'description') {
                    $user['address'] = $field['value'];
                }
            }
            // Now use $user for your ID card generation
        } else {
            // handle no record found
        }
        // var_dump($entry);
        // exit;
        
        
    } catch (Exception $e) {
        $error = "Error fetching data: " . $e->getMessage();
    }
} else {
    $error = "No Unique Code provided.";
}
// die(var_dump($params));
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
            <img src="https://amdon.com.ng/assets/img/logo/logo.png" style="max-width: 150px;">
            <br>
            <img src="https://www.shutterstock.com/image-vector/man-shirt-tie-businessman-avatar-600nw-548848999.jpg" style="max-width: 150px;">
            <!-- <h1 id="badgeEvent">Yootify</h1> -->
        </div>
        <div class="badge-body">
            <h2 id="badgeName"><?=$user['full_name']; ?></h2>
            <p id="badgeDesignation"><?=$user['dealer_name']; ?> (CEO)</p>
            <p id="badgeDesignation">Member ID: <?=$user['id']; ?></p>
        </div>
        <div id="qrcode" class="badge-qr">
        </div>
        <h3 id="badgecontainer">Address: <?=$user['address']; ?></h3><br>
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