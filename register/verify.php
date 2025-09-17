<?php
require 'head.php';

if (!isset($_GET['reference'])) {
        header('Location: /');
}

$reference = $_GET['reference'];
$secret_key = "sk_test_b1720b597be42c297ffc2e90f9a25f3e088efcf5";

$url = "https://api.paystack.co/transaction/verify/" . $reference;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $secret_key",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response);

// if () {
//     echo "Payment successful. Transaction ID: " . $result->data->id;
// } else {
//     echo "Payment failed or not verified.";
// }
if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
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
                                    <a href="idcard?uuid=<?=$uuid ?>" class="btn btn-success idcard-btn">Generate Your ID Card.</a>
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