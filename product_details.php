<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
} else {
    echo "Product not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <a href="menu.html">Back to Menu</a>
</header>

<main>
    <h1>Product Details</h1>
    <div class="product-detail">
        <img src="images/<?= $product['image']; ?>" alt="<?= $product['name']; ?>" width="200">
        <h2><?= $product['name']; ?></h2>
        <p><strong>Price:</strong> ₹<?= number_format($product['price'], 2); ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($product['description'])); ?></p>
        <button class="add-to-cart" data-id="<?= $product['id']; ?>" data-name="<?= $product['name']; ?>" data-price="<?= $product['price']; ?>" data-image="images/<?= $product['image']; ?>">Add to Cart</button>
    </div>
</main>

<script>
document.querySelector('.add-to-cart').onclick = function() {
    // Code for adding the item to the cart
    alert('Product added to cart');
}
</script>

</body>
</html>
