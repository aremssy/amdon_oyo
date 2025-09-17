<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  $url = "https://api.paystack.co/transaction/initialize";
  if (isset($_POST['amount'])) {
    $amount = $_POST['amount'] * 100;
  }
  // die(var_dump($amount));
  $fields = [
    'email' => "customer@email.com",
    'amount' => $amount
  ];

  $fields_string = http_build_query($fields);

  //open connection
  $ch = curl_init();
  
  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer sk_test_b1720b597be42c297ffc2e90f9a25f3e088efcf5",
    "Cache-Control: no-cache",
  ));
  
  //So that curl_exec returns the contents of the cURL; rather than echoing it
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
  
  //execute post
  $result = curl_exec($ch);

  $data = json_decode($result,true);
  $authorization_url = $data['data']['authorization_url'];
  if ($result) {
        header('Location: ' . $authorization_url);
    } else {
        echo "Error: " . $conn->error;
    }
?>