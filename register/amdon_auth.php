<?php
// amdon_auth.php

define('SUITECRM_REST_URL', 'https://datastore.oncloud.com.ng/service/v4_1/rest.php');
define('API_USERNAME', 'Admin');
define('API_PASSWORD', 'Pa22w0rd');

// Your Google reCAPTCHA secret key
define('RECAPTCHA_SECRET', '6LeGA9QrAAAAADBBfOygU_eltM6kdIBzT-SMcWAx');

// Your Cloudinary credentials
define('CLOUDINARY_CLOUD_NAME', 'dwratfmwb');
define('CLOUDINARY_API_KEY', '389496784768372');
define('CLOUDINARY_API_SECRET', 'tppL1IKELjzb6pXFXJseMi_m7OE');

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

function suitecrmApiLogin($username, $password) {
    $user_auth = [
        'user_name' => $username,
        'password' => md5($password),
        'version' => '1.1'
    ];

    $args = ['user_auth' => $user_auth, 'application_name' => 'Amdon App'];

    $response = restRequest('login', $args);
    if (isset($response['id'])) {
        return $response['id'];
    }
    throw new Exception('SuiteCRM login failed');
}

function registerDealer($session, $data) {
    $name_value_list = [
        ['name' => 'ticker_symbol', 'value' => $data['nin']],
        ['name' => 'name', 'value' => $data['full_name']],
        ['name' => 'phone_office', 'value' => $data['phone_number']],
        ['name' => 'email1', 'value' => $data['email']],
        ['name' => 'ownership', 'value' => $data['dealer_name']],
        ['name' => 'industry', 'value' => $data['state']],
        ['name' => 'employees', 'value' => $data['lga']],
        ['name' => 'annual_revenue', 'value' => $data['hashed_password']],
        ['name' => 'description', 'value' => $data['address']],
        ['name' => 'rating', 'value' => "AMD-OY-" . date('y ') . rand(9999)],
        ['name' => 'passport_url', 'value' => $data['passport_url'] ?? ''],
    ];

    $args = [
        'session' => $session,
        'module_name' => 'AMD_Members',
        'name_value_list' => $name_value_list,
    ];

    $response = restRequest('set_entry', $args);
    if (isset($response['id'])) {
        return $response['id'];
    }
    throw new Exception('Failed to register dealer: ' . json_encode($response));
}

// Cloudinary REST API upload (signed)
function cloudinary_signed_upload($filePath) {
    $timestamp = time();
    $publicId = "amdon_passports/passport_" . $timestamp;
    $cloudName = CLOUDINARY_CLOUD_NAME;
    $apiKey = CLOUDINARY_API_KEY;
    $apiSecret = CLOUDINARY_API_SECRET;

    $paramsForSignature = "public_id={$publicId}&timestamp={$timestamp}{$apiSecret}";
    $signature = sha1($paramsForSignature);

    $url = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";

    $postFields = [
        'file' => new CURLFile($filePath),
        'api_key' => $apiKey,
        'timestamp' => $timestamp,
        'public_id' => $publicId,
        'signature' => $signature,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception('Cloudinary upload failed: ' . curl_error($ch));
    }
    curl_close($ch);

    $result = json_decode($response, true);
    if (isset($result['secure_url'])) {
        return $result['secure_url'];
    }
    throw new Exception('Cloudinary upload error: ' . $response);
}
function formatToInternational($phone) {
    // Remove all non-numeric characters
    $phone = preg_replace('/\D/', '', $phone);

    // If it starts with '234' already
    if (substr($phone, 0, 3) === '234') {
        return '+' . $phone;
    }

    // If it starts with '0', remove it and add +234
    if (substr($phone, 0, 1) === '0') {
        $phone = substr($phone, 1);
    }

    // Keep last 10 digits (in case number is longer)
    $phone = substr($phone, -10);

    return '+234' . $phone;
}
function checkDuplicateInSuiteCRM($session_id, $url, $module, $field, $value) {
    // Sanitize inputs
    $allowed_fields = ['email', 'phone'];
    if (!in_array($field, $allowed_fields)) {
        return ['status' => 'error', 'message' => 'Invalid field'];
    }

    // Map field name to SuiteCRM field
    $crm_field = ($field === 'email') ? 'amd_members.email1' : 'amd_members.phone_office';

    // Build query
    $query = "$crm_field = '$value'";

    // Prepare request data
    $data = [
        "session" => $session_id,
        "module_name" => $module,
        "query" => $query,
        "select_fields" => ["id"],
        "max_results" => 1,
        "deleted" => 0
    ];

    // Send API request
    $curl = curl_init($url . '/service/v4_1/rest.php');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, [
        "method" => "get_entry_list",
        "input_type" => "JSON",
        "response_type" => "JSON",
        "rest_data" => json_encode($data)
    ]);

    $result = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($result, true);
    $count = isset($response['result_count']) ? $response['result_count'] : 0;

    if ($count > 0) {
        return ['status' => 'exists'];
    } else {
        return ['status' => 'available'];
    }
}
if (isset($_POST['check_field']) && isset($_POST['value'])) {
    // Make sure session and SuiteCRM connection exist
    $field = $_POST['check_field'];
    $value = $_POST['value'];

    // Assuming you already have $session_id and $url available from your SuiteCRM connection
    $module = 'AMD_Members'; // or 'Leads' depending on where you store registrations
// Login to SuiteCRM API
    $session = suitecrmApiLogin(API_USERNAME, API_PASSWORD);
    $result = checkDuplicateInSuiteCRM($session, SUITECRM_REST_URL, $module, $field, $value);

    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'register') {
        try {
            // Verify CAPTCHA first
            $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
            $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_SECRET . "&response={$recaptcha_response}");
            $captchaResult = json_decode($verify_response, true);
            if (empty($captchaResult['success']) || !$captchaResult['success']) {
                throw new Exception('CAPTCHA verification failed');
            }

            // Validate and upload passport image
            if (!isset($_FILES['passport']) || $_FILES['passport']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Passport photo is required");
            }
            $passportUrl = cloudinary_signed_upload($_FILES['passport']['tmp_name']);

            // Hash password securely
            $hashed_password = password_hash($_POST['hashed_password'], PASSWORD_BCRYPT);

            // Login to SuiteCRM API
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
                'address' => $_POST['address'],
                'passport_url' => $passportUrl,
            ];

            $recordId = registerDealer($session, $dealerData);

            if ($recordId) {
                // Send WhatsApp Message
                $curl = curl_init();
                $phone_number = formatToInternational($_POST['phone_number']);
                // die(var_dump($phone_number));
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://wamsender.com/api/create-message',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => array(
                  'appkey' => '2860f5e3-82b0-4be2-b147-2f4063e4d1b2',
                  'authkey' => 'aoBWWW94zGfx2lDgyVEiab1qsZS7Das7bhe9IpXUoroBlNxyCW',
                  'to' => $phone_number,
                  'message' => 'Welcome to AMDON Oyo Chapter',
                  'file' => 'https://amdon.com.ng/register/assets/images/amdon_logo_main.jpg',
                  'sandbox' => 'false'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                echo $response;
                echo json_encode([
                    'success' => true,
                    'message' => 'Registration successful',
                    'redirect' => 'payment?uuid=' . urlencode($recordId) . '&status=1'
                ]);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => "Could not get record ID. Registration incomplete."]);
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    }

    if ($_POST['action'] === 'login') {
        try {
            $phone = $_POST['phone_number'];
            $password = $_POST['password'];

            $apiSession = suitecrmApiLogin(API_USERNAME, API_PASSWORD);
            $dealerEntry = findDealerByPhone($apiSession, $phone);
            if (!$dealerEntry) {
                throw new Exception("Phone Number does not exist in our Database.");
            }

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

            if (!password_verify($password, $hashedPassword)) {
                throw new Exception("Invalid Phone Number or Password.");
            }

            $dealerId = $dealerEntry['id'];
            echo json_encode(['success' => true, 'message' => 'Login successful', 'dealer_id' => $dealerId]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}

?>