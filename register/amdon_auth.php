<?php
// amdon_auth.php

define('SUITECRM_REST_URL', 'https://datastore.oncloud.com.ng/service/v4_1/rest.php');
define('API_USERNAME', 'Admin');  // API user for SuiteCRM API calls
define('API_PASSWORD', 'Pa22w0rd');  // Plain password for API user (md5 hashed for login)

// Function to find dealer record by phone number from custom module
function findDealerByPhone($session, $phone) {
    $restData = [
        'session' => $session,
        'module_name' => 'AMD_Members',  // your custom module
        'query' => "phone_office = '{$phone}'",
        'order_by' => '',
        'offset' => 0,
        'select_fields' => ['id', 'annual_revenue', 'phone_office', 'name'],
        'max_results' => 1,
        'deleted' => 0,
        'favorite_conditions' => false
    ];

    $response = restRequest('get_entry_list', $restData);
    if (empty($response['entry_list'])) {
        return null;
    }
    return $response['entry_list'][0];
}

// Simplified REST request function
function restRequest($method, $arguments) {
    $postData = [
        'method' => $method,
        'input_type' => 'JSON',
        'response_type' => 'JSON',
        'rest_data' => json_encode($arguments),
    ];

    $ch = curl_init(SUITECRM_REST_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Login method: get a session ID for API calls
function suitecrmApiLogin($username, $password) {
    $user_auth = [
        'user_name' => $username,
        'password' => md5($password),  // SuiteCRM expects md5 password hash for login method
        'version' => '1.1'
    ];

    $args = ['user_auth' => $user_auth, 'application_name' => 'Amdon App'];

    $response = restRequest('login', $args);
    if (isset($response['id'])) {
        return $response['id'];
    }
    throw new Exception('SuiteCRM login failed');
}

// Register dealer in custom module
function registerDealer($session, $data) {
    $name_value_list = [
        ['name' => 'ticker_symbol', 'value' => $data['nin']],
        ['name' => 'name', 'value' => $data['full_name']],
        ['name' => 'phone_office', 'value' => $data['phone_number']],
        ['name' => 'email1', 'value' => $data['email']],
        ['name' => 'ownership', 'value' => $data['dealer_name']],
        ['name' => 'industry', 'value' => $data['state']],
        ['name' => 'employees', 'value' => $data['lga']],
        ['name' => 'annual_revenue', 'value' => $data['hashed_password']],  // Store bcrypt hash securely
        ['name' => 'description', 'value' => $data['address']],   // Store bcrypt hash securely
        ['name' => 'rating', 'value' => "AMD-OY-".date('Y').rand(9999)],    
    ];
    $args = [
        'session' => $session,
        'module_name' => 'AMD_Members',  // Replace with your actual custom module name
        'name_value_list' => $name_value_list,
    ];

    $response = restRequest('set_entry', $args);
    if (isset($response['id'])) {
        return $response['id'];
    }
    throw new Exception('Failed to register dealer: ' . json_encode($response));
}

    // Processing form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'register') {
            try {
                // Securely hash plain password from form
                $hashed_password = password_hash($_POST['hashed_password'], PASSWORD_BCRYPT);
    
                // Login with API user to SuiteCRM for saving data
                $session = suitecrmApiLogin(API_USERNAME, API_PASSWORD);
    
                $dealerData = [
                    'nin' => $_POST['nin'],
                    'full_name' => $_POST['full_name'],
                    'phone_number' => $_POST['phone_number'],
                    'email' => $_POST['email'],
                    'dealer_name' => $_POST['dealer_name'],
                    'state' => $_POST['state'],                
                    'lga' => $_POST['lga'],
                    'hashed_password' => $hashed_password,
                    'address' => $_POST['address']
                ];
    
                $recordId = registerDealer($session, $dealerData);
                // die(var_dump($recordId));
                if ($recordId) {
                    // header('Location: payment?uuid=' . urlencode($recordId) . '&status=1');
                    echo json_encode([
                        'success' => true,
                        'message' => 'Registration successful',
                        'redirect' => 'payment?uuid=' . urlencode($recordId) . '&status=1'
                    ]);
                    exit;
                } else {            
                    echo json_encode(['success' => true, 'message' => "Could not get record ID. Registration incomplete.", 'id' => $recordId]);

                }
    
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit;
        }
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
            try {
                $phone = $_POST['phone_number'];  // Phone number input
                $password = $_POST['password'];
    
                // Login with API user to query SuiteCRM
                $apiSession = suitecrmApiLogin(API_USERNAME, API_PASSWORD);
    
                // Find dealer record by phone number
                $dealerEntry = findDealerByPhone($apiSession, $phone);
                if (!$dealerEntry) {
                    throw new Exception("Phone Number does not exist in our Database.");
                }
    
                // Extract stored hashed password from the entry
                $hashedPassword = '';
                foreach ($dealerEntry['name_value_list'] as $field) {
                    if ($field['name'] === 'annual_revenue') {
                        $hashedPassword = $field['value'];
                        break;
                    }
                }
    
                if (!$hashedPassword) {
                    throw new Exception("Password not set for user.");
                }
    
                // die(var_dump($hashedPassword));
                // Verify submitted password matches stored hash
                if (!password_verify($password, $hashedPassword)) {
                    throw new Exception("Invalid Phone Number or Password.");
                }
    
                // Login success, return success message and record id
                $dealerId = $dealerEntry['id'];
                echo json_encode(['success' => true, 'message' => 'Login successful', 'dealer_id' => $dealerId]);
    
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit;
        }
}
?>
