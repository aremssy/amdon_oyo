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
        ['name' => 'rating', 'value' => "AMD-OY-" . date('Y') . rand(9999)],
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