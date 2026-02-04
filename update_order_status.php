<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "admindb", 3307); // Update with your actual credentials

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the order ID and new status from the POST data
$orderId = $_POST['orderId'];
$newStatus = $_POST['newStatus'];

// Update the order status in the database
$sql = "UPDATE orders SET status = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $newStatus, $orderId);

// Execute the query
if ($stmt->execute()) {
    // Success response
    echo json_encode(['success' => true]);
} else {
    // Failure response
    echo json_encode(['success' => false]);
}

// Close the connection
$stmt->close();
$mysqli->close();
?>
