<?php 
require 'head.php';
 ?>

    <!-- background -->
    <div class="ls-bg">
        <img class="ls-bg-inner" src="assets/images/man-car-bg.jpg" alt="">
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

                            <!-- login sign up button -->
                            <div class="logSign">
                                <button id="showlogin" type="button" class="active">Login</button>
                                <button id="showregister" type="button">register</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 tab-100">

                        <!-- form -->
                        <div class="form">
                                <h2 class="login-form form-title">
                                    Account Login
                                </h2>
                                <h2 class="signup-form form-title">
                                    Create your Account!
                                </h2>

                                <!-- login form -->
                            <form id="step1" class="login-form" action="amdon_auth.php" method="POST">
                                <input type="hidden" name="action" value="login">
                                <div class="input-field">
                                    <input type="text"  name="phone_number" id="username" required>
                                    <label>
                                        Phone Number
                                    </label>
                                </div>
                                <div class="input-field delay-100ms">
                                    <input type="password"  name="password" id="password" required>
                                    <label>
                                        Password
                                    </label>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="rememberme">
                                        <input type="checkbox">
                                        <label>Remember Me</label>
                                    </div>
                                    <a href="#" class="forget">forget password</a>
                                </div>
                                <div class="login-btn">
                                    <button type="submit" class="login">Login to your Account!</button>
                                </div>
                            </form>

                            <!-- sign up form -->
                            <form id="step2" class="signup-form" method="post" action="amdon_auth.php">
                                
                                <input type="hidden" name="action" value="register">
                                <div class="input-field">
                                    <input type="text"  name="nin" id="mail-email" required>
                                    <label>
                                        NIN
                                    </label>
                                </div>
                                <div class="input-field">
                                    <input type="text"  name="full_name" id="mail-email" required>
                                    <label>
                                        Full Name
                                    </label>
                                </div>
                                <div class="input-field">
                                    <input type="text"  name="phone_number" id="mail-email" required>
                                    <label>
                                        Phone Number
                                    </label>
                                </div>
                                <div class="input-field">
                                    <input type="text"  name="email" id="mail-email" required>
                                    <label>
                                        Your Email
                                    </label>
                                </div>
                                <div class="input-field delay-100ms">
                                    <input type="text"  name="dealer_name" id="user" required>
                                    <label>
                                        Dealer Name
                                    </label>
                                </div>
                                <div class="input-field delay-100ms">
                                    <input type="text"  name="state" id="user" value="Oyo State" readonly required>
                                    <label>
                                        <!-- State -->
                                    </label>
                                </div>
                                <div class="input-field delay-200ms">
                                    <input type="text"  name="lga" id="password" required>
                                    <label>
                                        LGA
                                    </label>
                                </div>
                                <div class="input-field delay-200ms">
                                    <input type="password"  name="hashed_password" id="password" required>
                                    <label>
                                        Password
                                    </label>
                                </div>
                                <div class="input-field delay-200ms">
                                    <!-- <input type="text"  name="address" id="password" required> -->
                                    <textarea name="address" id="address" required>
                                        
                                    </textarea>
                                    <label>
                                        Address
                                    </label>
                                </div>
                                <div class="rememberme">
                                    <input type="checkbox">
                                    <label>Send me news and updates via email</label>
                                </div>
                                <div class="login-btn">
                                    <button type="submit" class="signup">Register Now!</button>
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

    <!-- My js -->
    <script src="assets/js/custom.js"></script>
    
  <script>
        $(document).ready(function() {
          // Show messages to user above form
          function showMessage(form, message, isError) {
            let messageBox = form.find('.form-message');
            if (!messageBox.length) {
              messageBox = $('<div class="form-message" role="alert" aria-live="assertive"></div>');
              form.prepend(messageBox);
            }
            messageBox.text(message);
            messageBox.css('color', isError ? 'red' : 'green');
          }
        
          // Simple Email Regex for validation
          function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
          }
        
          // Validate registration form fields
          function validateRegistration(form) {
            const nin = form.find('[name="nin"]').val().trim();
            const fullName = form.find('[name="full_name"]').val().trim();
            const phone = form.find('[name="phone_number"]').val().trim();
            const email = form.find('[name="email"]').val().trim();
            const dealerName = form.find('[name="dealer_name"]').val().trim();
            const state = form.find('[name="state"]').val().trim();
            const lga = form.find('[name="lga"]').val().trim();
            const password = form.find('[name="hashed_password"]').val();
            const unique = form.find('[name="unique"]').val();
        
            if(!nin) { showMessage(form, "NIN is required.", true); return false; }
            if(!fullName) { showMessage(form, "Full name is required.", true); return false; }
            if(!phone) { showMessage(form, "Phone number is required.", true); return false; }
            if(!email || !isValidEmail(email)) { showMessage(form, "Valid email is required.", true); return false; }
            if(!dealerName) { showMessage(form, "Dealer name is required.", true); return false; }
            if(!state) { showMessage(form, "State is required.", true); return false; }
            if(!lga) { showMessage(form, "LGA is required.", true); return false; }
            if(!password || password.length < 6) { showMessage(form, "Password must be at least 6 characters.", true); return false; }
        
            return true;
          }
        
          // Validate login form fields
          function validateLogin(form) {
            const username = form.find('[name="phone_number"]').val().trim();
            const password = form.find('[name="password"]').val();
        
            if(!username) { showMessage(form, "Phone number is required for login.", true); return false; }
            if(!password) { showMessage(form, "Password is required for login.", true); return false; }
        
            return true;
          }
        
          // AJAX form submission handler
          $('form').on('submit', function(e) {
            e.preventDefault();
        
            let form = $(this);
            let action = form.find('[name="action"]').val();
        
            let isValid = action === 'register' ? validateRegistration(form) : validateLogin(form);
            if (!isValid) return;
        
            let url = form.attr('action') || 'amdon_auth.php';
            let formData = new FormData(this);
        
            let submitBtn = form.find('button[type="submit"]');
            submitBtn.prop('disabled', true).text('Please wait...');
        
            $.ajax({
              url: url,
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              dataType: 'json',
              success: function(response) {
                if (response.success) {
                  showMessage(form, response.message, false);
                  if (action === 'register') {
                    window.location.href = response.redirect;
                    }
                  if(action === 'login') {
                    // Redirect or reload on success login as needed
                    window.location.href = 'dashboard.php';
                  }
                } else {
                  showMessage(form, response.message || "Error occurred", true);
                }
              },
              error: function() {
                showMessage(form, "Server error or no response.", true);
              },
              complete: function() {
                submitBtn.prop('disabled', false).text(form.data('original-btn-text') || 'Submit');
              }
            });
          });
        
          // Store original button text to restore after AJAX
          $('form button[type="submit"]').each(function() {
            let btn = $(this);
            btn.data('original-btn-text', btn.text());
          });
        
          // Initialize form message containers clean on page load
          $('.form-message').remove();
        });
</script>



</body>

<!-- Mirrored from templates.seekviral.com/trimba3/forms/CompanyRegistrationPage/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Jan 2025 10:33:40 GMT -->
</html>