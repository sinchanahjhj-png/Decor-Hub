<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if ($id) {
  $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    header("Location: admin_products.php");
    exit;
  } else {
    echo "Error deleting product.";
  }
} else {
  echo "No product ID provided.";
}
?>
