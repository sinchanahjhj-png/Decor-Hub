<?php
session_start();

// DB connection settings
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "admindb";
$port = 3307;

// Create DB connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Simulated order details (in real case, they should come from a form input)
$user_id = $_SESSION['user_id'];  // User logged in ID
$product_id = 1;  // Example product (Comfort Chair)
$quantity = 2;  // Example quantity
$payment_method = 'Credit Card';  // Example payment method

// Fetch product price
$product_result = $conn->query("SELECT price FROM products WHERE id = $product_id");

if ($product_result->num_rows == 0) {
    die("Product not found.");
}

$product = $product_result->fetch_assoc();
$price = $product['price'];
$total_amount = $quantity * $price;  // Calculate total amount

// Prepare SQL query to insert order into the `orders` table
$stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, total_amount, order_date, payment_method, quantity) VALUES (?, ?, ?, NOW(), ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("iiids", $user_id, $product_id, $total_amount, $payment_method, $quantity);

if ($stmt->execute()) {
    echo "Order placed successfully!";
} else {
    echo "Order failed: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
