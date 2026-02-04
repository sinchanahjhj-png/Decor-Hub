<?php
include 'db.php';

// Fetch categories
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

echo "<div class='product-menu'>";
while ($row = $result->fetch_assoc()) {
    echo "<button id='" . $row['name'] . "' onclick='window.location.href=\"products.php?category=" . $row['name'] . "\"'>" . $row['name'] . "</button>";
}
echo "</div>";

$conn->close();
?>
