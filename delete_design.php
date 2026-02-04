<?php
// DB Config
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "admindb";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Delete the design from the database
    $deleteQuery = "DELETE FROM designs WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: adesign.php");
}

$stmt->close();
$conn->close();
?>
