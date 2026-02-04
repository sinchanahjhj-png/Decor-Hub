<?php
$host = "localhost";
$user = "root";     // Your DB username
$pass = "";         // Your DB password
$dbname = "userdb";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
