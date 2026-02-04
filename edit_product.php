<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  die("Product ID is missing.");
}

// Fetch product
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $category = $_POST['category'];
  $price = $_POST['price'];

  // Handle image upload
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $updateQuery = "UPDATE products SET name=?, category=?, price=?, image=? WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssdsi", $name, $category, $price, $image, $id);
  } else {
    $updateQuery = "UPDATE products SET name=?, category=?, price=? WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssdi", $name, $category, $price, $id);
  }

  if ($stmt->execute()) {
    header("Location: aproduct.php");
    exit;
  } else {
    echo "Failed to update product.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
</head>
<body>

  <h2>Edit Product</h2>
  <form method="POST" enctype="multipart/form-data">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $product['name'] ?>" required><br><br>

    <label>Category:</label><br>
    <input type="text" name="category" value="<?= $product['category'] ?>" required><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br><br>

    <label>Image:</label><br>
    <input type="file" name="image"><br>
    <small>Current: <?= $product['image'] ?></small><br><br>

    <button type="submit">Update</button>
  </form>

</body>
</html>
