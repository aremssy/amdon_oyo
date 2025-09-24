<?php
require '../register/SuiteCRMClient.php'; // your SuiteCRMClient class file
header('Content-Type: application/json');

$user = null;
$user_id = isset($_GET['user_id']) ? trim($_GET['user_id']) : '';
$selectFields = ['name', 'phone_office', 'id', 'ownership','address','email1','employees'];
// echo json_encode($user_id);
//             exit;

if ($user_id !== '') {
    // Instantiate and login SuiteCRM client
    $crmClient = new SuiteCRMClient();

    try {
        $crmClient->login();

        // Search the Amdon_Dealers module for record with matching unique_code
        $entry = $crmClient->getRecordById('AMD_Members', $user_id, $selectFields);

        if ($entry) {
            $user = [];
            foreach ($entry as $field) {
                if ($field['name'] === 'name') {
                    $user['full_name'] = $field['value'];
                } elseif ($field['name'] === 'phone_office') {
                    $user['phone_number'] = $field['value'];
                } elseif ($field['name'] === 'ownership') {
                    $user['dealer_name'] = $field['value'];
                } elseif ($field['name'] === 'id') {
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
            echo json_encode($user);
            exit;
        } else {
            echo json_encode(['error' => 'User not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid user ID']);
}
?>