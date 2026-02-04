<?php
// DB Config
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "admindb";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch designs from the database
$query = "SELECT id, name, price, description, image_path, category FROM designs";
$result = $conn->query($query);

// Folder mapping based on categories
$folderMap = [
    'kitchen' => 'kitchen_img',
    'bedroom' => 'bedroom_img',
    'living' => 'living_img',
    'bathroom' => 'bathroom_img',
    'prayer' => 'pr_img'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Designs</title>
    <link rel="stylesheet" href="adesign.css">
</head>
<body>

<div class="header">
    <h2>Designs Admin Panel</h2>
    <a href="adashboard.html" class="back-btn">Back to Dashboard</a>
</div>

<table class="design-table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): 
            // Determine the folder based on category
            $categoryFolder = $folderMap[$row['category']] ?? 'kitchen_img';
            // Construct the image path
            $imagePath = "images/{$categoryFolder}/" . $row['image_path'];
            
            // Check if the image exists in the directory (for debugging)
            if (!file_exists($imagePath)) {
                echo "Image not found: " . $imagePath; // Output for debugging
            }
        ?>
            <tr>
                <td><img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($row['name']) ?>" width="100" /></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>₹ <?= number_format($row['price'], 2) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td>
                    <a href="edit_design.php?id=<?= $row['id'] ?>">Edit</a> | 
                    <a href="delete_design.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>
