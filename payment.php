<?php
session_start();

// Check if the user is logged in (modify this according to your authentication logic)
if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "admindb", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected product from the URL
$productId = isset($_GET['product_id']) ? $_GET['product_id'] : 0;
if ($productId <= 0) {
    die("Invalid product.");
}

// Fetch the product details
$productQuery = $conn->query("SELECT * FROM products WHERE product_id = $productId");
$product = $productQuery->fetch_assoc();
if (!$product) {
    die("Product not found.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment</title>
</head>
<body>

<h2>Product: <?php echo htmlspecialchars($product['name']); ?></h2>
<img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" />
<p>Price: ₹<?php echo number_format($product['price'], 2); ?></p>

<h3>Select Payment Method</h3>
<form action="process_order.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>" />
    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>" />
    <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />

    <label>
        <input type="radio" name="payment_method" value="UPI" required> UPI
    </label><br>
    <label>
        <input type="radio" name="payment_method" value="Card" required> Credit/Debit Card
    </label><br>
    <label>
        <input type="radio" name="payment_method" value="NetBanking" required> Net Banking
    </label><br>

    <button type="submit">Confirm Payment</button>
</form>

</body>
</html>

<?php
$conn->close();
?>
