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

// Fetch new arrivals from the database
$query = "SELECT id, name, price, image FROM new_arrivals";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Arrivals</title>
    <link rel="stylesheet" href="anewarr.css">
</head>
<body>

<div class="header">
    <h2>New Arrivals</h2>
    <a href="add_new_arrival.php" class="add-btn">Add New Arrival</a>
    <a href="adashboard.html" class="back-btn">Back to Dashboard</a>
</div>

<table>
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <?php
                    // Set the image path to the 'images/new_arrivals/' folder
                    $imagePath = "images/new_arrivals/" . htmlspecialchars($row['image']);
                ?>
                <td><img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['name']) ?>" width="100" /></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>₹ <?= number_format($row['price'], 2) ?></td>
                <td>
                    <a href="edit_new_arrival.php?id=<?= $row['id'] ?>">Edit</a> | 
                    <a href="delete_new_arrival.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>
