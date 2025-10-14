<?php
session_start();
require 'head.php';
require 'SuiteCRMClient.php'; // your OOP client class file

function shorten($longUrl) {
    $data = [
        "domain" => "clc.is",
        "target_url" => $longUrl,
        // optionally "slug" => "customname",
        // optionally "expired_hours" => 48,
    ];

    $ch = curl_init("https://clc.is/api/links");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    if ($response === false) {
        throw new Exception("Curl error: " . curl_error($ch));
    }
    curl_close($ch);

    $obj = json_decode($response, true);
    if (isset($obj[0]['url'])) {
        return $obj[0]['url'];  // the shortened URL
    } else {
        throw new Exception("Error shortening URL: " . $response);
    }
}
// Verify GET parameters
if (!isset($_GET['reference']) || !isset($_GET['uuid'])) {
    header('Location: /');
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$reference = $_GET['reference'];
$uuid = $_GET['uuid'];  // The dealer record ID

// $secret_key = "sk_test_b1720b597be42c297ffc2e90f9a25f3e088efcf5";
$secret_key = "sk_live_999798493486dde41b15cd931d04482989cc574a";
$paystackApiUrl = "https://api.paystack.co/transaction/verify/" . urlencode($reference);

// Initialize curl to verify payment
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $paystackApiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $secret_key",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response);

if (!$result || !$result->status || $result->data->status !== "success") {
    echo json_encode(['success' => false, 'message' => 'Payment verification failed']);
    exit;
}

// Payment succeeded - now record it in SuiteCRM
try {
    // Instantiate SuiteCRM client
    $crmClient = new SuiteCRMClient();

    // Login to SuiteCRM
    if (!$crmClient->login()) {
        throw new Exception("SuiteCRM API login failed");
    }

    // Prepare payment record data
    $paymentData = [
        ['name' => 'name', 'value' => 'Payment for Dealer ' . $uuid],
        ['name' => 'transaction_id', 'value' => $result->data->id],
        ['name' => 'amount', 'value' => $result->data->amount / 100], // convert kobo to naira
        ['name' => 'payment_status', 'value' => 'Completed'],
        ['name' => 'date_entered', 'value' => date('Y-m-d H:i:s')],
        ['name' => 'related_dealer', 'value' => $uuid]  // adjust to your actual relationship field
    ];

    // Create new payment record
    $newPaymentId = $crmClient->setEntry('AMD_Fees', $paymentData);

    if ($newPaymentId) {

        $url_idcard = "https://amdon.com.ng/"."idcard?uuid=". $uuid;
        $short = shorten($url_idcard);
        $phone_number = $_SESSION['phone_number'];
         // Message
        $msg = "Congratulations! \nYou’ve successfully registered to the AMDON Database! Kindly download your Oyo state membership verification tag via this link below. \n\n Stay tuned for updates. \n\n Tag Link: ". $short ."\n\nThank You,\nAMDON Chairman \nOyo State Chapter.";
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
          'message' => $msg,
          'file' => 'https://amdon.com.ng/register/assets/images/amdon_logo_main.jpg',
          'sandbox' => 'false'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        echo json_encode([
            'success' => true,
            'message' => 'Payment recorded successfully',
            'payment_id' => $newPaymentId
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to create payment record'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
 ?>

    <!-- background -->
    <div class="ls-bg">
        <img class="ls-bg-inner" src="assets/images/bg-car.jpg" alt="">
    </div>

    <main class="overflow-hidden">
        <div class="wrapper">
            <div class="main-inner">

                <!-- logo -->
                <div class="logo">
                    <div class="logo-icon">
                        <img src="assets/images/amdon_logo_main.jpg" alt="BeRifma">
                    </div>
                    <div class="logo-text">
                        
                    </div>
                </div>
                <div class="row h-100 align-content-center">

                    <div class="col-md-12 tab-100">

                        <!-- form -->
                        <div class="form">
                              <!--   <h2 class="login-form form-title">
                                    Make Payment
                                </h2> -->

                                <?php if ($result->status && $result->data->status == "success"): ?>
                                <img src="assets/images/payment_successful.png" style="max-width: 100%;">
                                <!-- <div class="alert alert-success" role="alert">
                                  You have successfully registered to the AMDON Oyo State Dealers Portal. 
                                  <br/><br/>Make registration payment to access your personal page and download your ID Card.
                                </div> -->
                                <?php else: ?>
                                  <?php header('Location: /');   ?>

                                <?php endif; ?>
                                <div class="" style="margin: 50px 0;">

                                    <a href="" class="btn btn-info login-btn">Login Now</a>
                                    <br>
                                    <a href="/idcard?uuid=<?=$uuid ?>" class="btn btn-success idcard-btn">Generate Your ID Card.</a>
                                    <!-- <button type="button" onclick="payWithPaystack()" class="login" style="background: #4CAF50;">Pay Later</button> -->
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    

    <div id="error">

    </div>


    <!-- Bootstrap-5 -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Jquery -->
    <script src="assets/js/jquery-3.6.1.min.js"></script>
    <!-- My js -->
    <script src="assets/js/custom.js"></script>

</body>

<!-- Mirrored from templates.seekviral.com/trimba3/forms/CompanyRegistrationPage/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Jan 2025 10:33:40 GMT -->
</html>