<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>AMDON Login & Registration</title>
<style>
  body {
    margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: url('assets/images/man-car-bg.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex; justify-content: center; align-items: center; height: 100vh;
  }
  .container {
    background-color: rgba(255,255,255,0.92);
    width: 420px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    overflow: hidden;
  }
  .header {
    text-align: center;
    padding: 20px 0;
    border-bottom: 1px solid #ddd;
  }
  .header img {
    max-width: 130px;
  }
  .header h1 {
    margin: 12px 0 6px;
    font-weight: 700;
    color: #222;
  }
  .tabs {
    display: flex;
    justify-content: center;
    background: #f7f7f7;
  }
  .tab {
    padding: 15px 40px;
    cursor: pointer;
    font-weight: 600;
    color: #666;
    border-bottom: 3px solid transparent;
    transition: color 0.3s, border-bottom-color 0.3s;
  }
  .tab.active {
    color: #1a73e8;
    border-bottom-color: #1a73e8;
  }
  form {
    padding: 20px 30px 30px;
  }
  .input-group {
    margin-bottom: 15px;
  }
  .input-group label {
    display: block;
    font-size: 0.9rem;
    margin-bottom: 5px;
    color: #444;
  }
  .input-group input, .input-group textarea {
    width: 100%;
    padding: 10px 12px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border-color 0.3s;
  }
  .input-group input:focus, .input-group textarea:focus {
    outline: none;
    border-color: #1a73e8;
  }
  textarea {
    resize: vertical;
    min-height: 80px;
  }
  button {
    background: #1a73e8;
    color: white;
    font-weight: 700;
    padding: 12px;
    border: none;
    border-radius: 5px;
    width: 100%;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s;
  }
  button:hover {
    background: #155ab6;
  }
  .optional-info {
    font-size: 0.85rem;
    color: #777;
    margin-top: 10px;
    text-align: center;
  }
  .optional-info a {
    color: #1a73e8;
    text-decoration: none;
  }
  .remember-me {
    display: flex; align-items: center; margin-bottom: 15px;
    font-size: 0.9rem;
  }
  .remember-me input[type="checkbox"] {
    margin-right: 8px;
  }
  .forgot-password {
    text-align: right;
    font-size: 0.85rem;
    margin-bottom: 15px;
  }
  .forgot-password a {
    color: #1a73e8;
    text-decoration: none;
  }
</style>
</head>
<body>

<div class="container" role="main" aria-label="AMDON Login and Registration">
  <div class="header">
    <img src="assets/images/amdon_logo_main.jpg" alt="AMDON Logo" />
    <h1>Association of Motor Dealer of Nigeria</h1>
  </div>

  <div class="tabs" role="tablist">
    <div class="tab active" id="login-tab" role="tab" aria-selected="true" tabindex="0" aria-controls="login-panel">Login</div>
    <div class="tab" id="register-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="register-panel">Register</div>
  </div>

  <!-- Login Panel -->
  <form id="login-panel" role="tabpanel" aria-labelledby="login-tab" aria-hidden="false" action="amdon_auth.php" method="POST" novalidate>
    <input type="hidden" name="action" value="login" />
    <div class="input-group">
      <label for="login-username">Phone Number</label>
      <input type="text" id="login-username" name="username" required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="login-password">Password</label>
      <input type="password" id="login-password" name="password" required aria-required="true" />
    </div>

    <div class="remember-me">
      <input type="checkbox" id="remember" name="remember" />
      <label for="remember">Remember Me</label>
    </div>
    <div class="forgot-password">
      <a href="#">Forgot password?</a>
    </div>

    <button type="submit">Login to your Account</button>
  </form>

  <!-- Registration Panel -->
  <form id="register-panel" role="tabpanel" aria-labelledby="register-tab" aria-hidden="true" action="amdon_auth.php" method="POST" novalidate>
    <input type="hidden" name="action" value="register" />
    <div class="input-group">
      <label for="reg-nin">NIN</label>
      <input type="text" name="nin" id="reg-nin" required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="reg-full-name">Full Name</label>
      <input type="text" name="full_name" id="reg-full-name" required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="reg-phone">Phone Number</label>
      <input type="text" name="phone_number" id="reg-phone" required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="reg-email">Email</label>
      <input type="email" name="email" id="reg-email" required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="reg-dealer-name">Dealer Name</label>
      <input type="text" name="dealer_name" id="reg-dealer-name" required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="reg-state">State</label>
      <input type="text" name="state" id="reg-state" value="Oyo State" readonly required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="reg-lga">LGA</label>
      <input type="text" name="lga" id="reg-lga" required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="reg-password">Password</label>
      <input type="password" name="password" id="reg-password" required aria-required="true" />
    </div>
    <div class="input-group">
      <label for="reg-address">Address</label>
      <textarea name="address" id="reg-address" required aria-required="true"></textarea>
    </div>
    <div class="remember-me">
      <input type="checkbox" id="subscribe" name="subscribe" />
      <label for="subscribe">Send me news and updates via email</label>
    </div>

    <button type="submit">Register Now</button>
    <p class="optional-info">You'll receive a confirmation email with a link to activate your account. If you have any problems, <a href="#">contact us</a>.</p>
  </form>
</div>

<script>
  const tabs = document.querySelectorAll('.tab');
  const loginPanel = document.getElementById('login-panel');
  const registerPanel = document.getElementById('register-panel');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // Remove active class and aria-selected from all tabs
      tabs.forEach(t => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
        t.setAttribute('tabindex', '-1');
      });
      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');
      tab.setAttribute('tabindex', '0');

      // Show related panel, hide the other
      if (tab.id === 'login-tab') {
        loginPanel.style.display = 'block';
        loginPanel.setAttribute('aria-hidden', 'false');
        registerPanel.style.display = 'none';
        registerPanel.setAttribute('aria-hidden', 'true');
      } else {
        registerPanel.style.display = 'block';
        registerPanel.setAttribute('aria-hidden', 'false');
        loginPanel.style.display = 'none';
        loginPanel.setAttribute('aria-hidden', 'true');
      }
    });
  });

  // Initialize display states
  loginPanel.style.display = 'block';
  registerPanel.style.display = 'none';
</script>

</body>
</html>