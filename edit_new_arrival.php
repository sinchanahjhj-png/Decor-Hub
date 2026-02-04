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

$id = $_GET['id'];

// Fetch the current data for the selected item
$query = "SELECT id, name, price, image FROM new_arrivals WHERE id = $id";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // If new image is uploaded, upload it and update the image name
    if ($image != "") {
        $target = "images/new_arrivals/" . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $updateQuery = "UPDATE new_arrivals SET name = '$name', price = '$price', image = '$image' WHERE id = $id";
        }
    } else {
        $updateQuery = "UPDATE new_arrivals SET name = '$name', price = '$price' WHERE id = $id";
    }

    if ($conn->query($updateQuery) === TRUE) {
        header("Location: new_arrival.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit New Arrival</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="header">
    <h2>Edit New Arrival</h2>
    <a href="new_arrival.php" class="back-btn">Back to New Arrivals</a>
</div>

<form action="edit_new_arrival.php?id=<?= $row['id'] ?>" method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= $row['name'] ?>" required>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" value="<?= $row['price'] ?>" required>

    <label for="image">Image (optional):</label>
    <input type="file" id="image" name="image" accept="image/*">

    <button type="submit">Update Arrival</button>
</form>

</body>
</html>
