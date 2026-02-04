<?php
include 'db.php'; // DB connection

// Fetch all products
$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Product Management</title>
  <link rel="stylesheet" href="admin.css"> <!-- Optional: your admin CSS -->
  <style>
    /* Style for the back button */
    .back-button {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: #007BFF;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
    }
    .back-button:hover {
      background-color: #0056b3;
    }

    /* Style for the product table */
    table {
      width: 100%;
      margin-top: 50px;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border: 1px solid #ddd;
    }
    th {
      background-color: #f4f4f4;
    }
    img {
      max-width: 60px;
      height: auto;
    }
  </style>
</head>
<body>

  <!-- Back Button -->
  <a href="adashboard.html" class="back-button">Back to Dashboard</a>

  <h1>Manage Products</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><img src="images/<?= $row['image'] ?>" alt="<?= $row['name'] ?>" width="60" /></td>
          <td><?= $row['name'] ?></td>
          <td><?= $row['category'] ?></td>
          <td>₹<?= number_format($row['price'], 2) ?></td>
          <td>
            <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

</body>
</html>
