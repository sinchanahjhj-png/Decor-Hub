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

$id = $_GET['id'] ?? null;

if ($id) {
    // Fetch the design to edit
    $query = "SELECT * FROM designs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $design = $result->fetch_assoc();
}

// Handle form submission to update the design
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image_path = $_POST['image_path'];
    $category = $_POST['category'];

    $updateQuery = "UPDATE designs SET name = ?, price = ?, description = ?, image_path = ?, category = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sdsssi", $name, $price, $description, $image_path, $category, $id);
    $updateStmt->execute();

    header("Location: adesign.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Design</title>
</head>
<body>

<h1>Edit Design</h1>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" value="<?= $design['name'] ?>" required><br>

    <label>Price:</label>
    <input type="number" name="price" value="<?= $design['price'] ?>" required><br>

    <label>Description:</label>
    <textarea name="description" required><?= $design['description'] ?></textarea><br>

    <label>Image Path:</label>
    <input type="text" name="image_path" value="<?= $design['image_path'] ?>" required><br>

    <label>Category:</label>
    <select name="category">
        <option value="kitchen" <?= ($design['category'] == 'kitchen') ? 'selected' : '' ?>>Kitchen</option>
        <option value="bedroom" <?= ($design['category'] == 'bedroom') ? 'selected' : '' ?>>Bedroom</option>
        <option value="living" <?= ($design['category'] == 'living') ? 'selected' : '' ?>>Living Room</option>
        <option value="bathroom" <?= ($design['category'] == 'bathroom') ? 'selected' : '' ?>>Bathroom</option>
        <option value="prayer" <?= ($design['category'] == 'prayer') ? 'selected' : '' ?>>Prayer Room</option>
    </select><br>

    <button type="submit">Update Design</button>
</form>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
