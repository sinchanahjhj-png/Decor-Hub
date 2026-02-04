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

// Check if user_id exists in session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Order details - Simulated (In real case, data should come from a form)
$user_id = $_SESSION['user_id'];
$product_id = 1; // Example: ordering product with ID 1 (e.g., Comfort Chair)
$quantity = 2; // Example: ordering 2 pieces of the product
$payment_method = 'Credit Card'; // Example: payment method

// Fetch the product price from the products table
$product_result = $conn->query("SELECT price FROM products WHERE id = $product_id");

// Debugging: Check if the product was found
if ($product_result->num_rows == 0) {
    die("Product not found.");
}

$product = $product_result->fetch_assoc();
$price = $product['price'];
$total_amount = $quantity * $price; // Total cost of the order

// Debugging: Checking variables before insertion
echo "User ID: $user_id, Product ID: $product_id, Quantity: $quantity, Total Amount: $total_amount, Payment Method: $payment_method<br>";

// Prepare the SQL query to insert the order into the orders table
$stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, total_amount, order_date, payment_method, quantity) VALUES (?, ?, ?, NOW(), ?, ?)");
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error); // Debugging
}

// Bind the parameters to the prepared statement
$stmt->bind_param("iiids", $user_id, $product_id, $total_amount, $payment_method, $quantity);

// Execute the query and check for success
if ($stmt->execute()) {
    echo "<p style='color:green;'>Order placed successfully!</p>";
} else {
    echo "<p style='color:red;'>Order failed: " . $stmt->error . "</p>";
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
