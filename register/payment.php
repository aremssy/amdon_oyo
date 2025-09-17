<?php 
require 'head.php';

if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
}else{
        header('Location: /');
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
                    <div class="col-md-4 tab-100 order_2">

                        <!-- side text -->
                        <div class="side-text">
                            <article>
                                <span>Join Our Verified Car Dealers.</span>
                                <h1 class="main-heading">AMDON</h1>
                                <p>
                                    Association of Motor Dealer of Nigeria (AMDON) is the unbralla body for all importers ans sellers of vehicles especially the imported fairly used popularly know as tokunbo in Nigeria. it is the solitary body having the supreme capacity to propel the innovation of automobile industry in Nigeria.
                                </p>
                            </article>

                          
                        </div>
                    </div>
                    <div class="col-md-8 tab-100">

                        <!-- form -->
                        <div class="form">
                                <h2 class="login-form form-title">
                                    Make Payment
                                </h2>

                                <div class="alert alert-success" role="alert">
                                  You have successfully registered to the AMDON Oyo State Dealers Portal. 
                                  <br/><br/>Make registration payment to access your personal page and download your ID Card.
                                </div>
                                <!-- login form -->
                            <form id="step1" class="login-form" method="post" action="">
                                <div class="input-field">
                                    <p>Registration Amount:</p>
                                    <input type="text"  name="amount" value="N5,000.00" id="username" readonly required style="height: 50px;">
                                    <input type="hidden"  name="uuid" value="<?= $retVal = (isset($_GET['uuid'])) ? $_GET['uuid'] : '' ; ?>" id="uuid" readonly style="height: 50px;">
                                    <!-- <label>
                                        Amount
                                    </label> -->
                                </div>
                                <div class="login-btn" style="margin: 50px 0;">

                                    <!-- <button type="submit" class="login">Pay Now</button> -->
                                    <button type="button" onclick="payWithPaystack()" class="login" style="background: #4CAF50;">Pay Later</button>
                                </div>
                            </form>


                            <!-- social sign in -->
                           <!--  <div class="login-form signup_social">
                                <div class="divide-heading">
                                    <span>Login with your Social Account</span>
                                </div>
                                <div class="social-signup">
                                    <a class="facebook" href="#"><i class="fa-brands fa-square-facebook"></i></a>
                                    <a class="twitter" href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a class="twitch" href="#"><i class="fa-brands fa-twitch"></i></a>
                                    <a class="youtube" href="#"><i class="fa-brands fa-youtube"></i></a>
                                </div>
                            </div> -->

                            
                            <div class="signup-form register-text">
                                You'll receive a confirmation email in your inbox with a link to activate your account. If you have any problems, <a href="#">contact us!</a> 
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

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <!-- My js -->
    <script src="assets/js/custom.js"></script>
    <script>
        function payWithPaystack() {
            let email = 'aremuhabib@gmail.com';
            let amount = 5000 * 100; // Convert to kobo
            let uuid = document.getElementById("uuid").value;

            if (uuid !='') {
                let handler = PaystackPop.setup({
                    key: 'pk_test_8b52e94ac10f9f3f56e68f7e9d415c657b8c1f88', 
                    email: email,
                    amount: amount,
                    currency: "NGN",
                    callback: function(response) {
                        window.location.href = "verify?reference=" + response.reference + "&uuid=" + uuid;
                    },
                    onClose: function() {
                        alert("Transaction canceled");
                    }
                });
                handler.openIframe();
            }
        }
</script>
</body>

</html>