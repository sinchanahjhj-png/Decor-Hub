<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "admindb";
$port = 3307;

// Create a connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Fetch the image name from the database to delete it from the folder
$query = "SELECT image FROM new_arrivals WHERE id = $id";
$result = $conn->query($query);
$row = $result->fetch_assoc();

$imagePath = "images/new_arrivals/" . $row['image'];

// Delete the item from the database
$deleteQuery = "DELETE FROM new_arrivals WHERE id = $id";

if ($conn->query($deleteQuery) === TRUE) {
    // Delete the image file from the server
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    header("Location: new_arrival.php");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
