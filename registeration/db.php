<?php
$servername = "localhost";
$username = "amdon_oyo"; // Replace with your DB username
$password = "35THFP56wmTXePrh";     // Replace with your DB password
$dbname = "amdon_oyo"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
