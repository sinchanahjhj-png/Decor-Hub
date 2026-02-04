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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "images/new_arrivals/" . basename($image);

    // Upload image
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Insert the new arrival into the database
        $query = "INSERT INTO new_arrivals (name, price, image) VALUES ('$name', '$price', '$image')";
        if ($conn->query($query) === TRUE) {
            echo "New arrival added successfully.";
            header("Location: new_arrival.php");
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Arrival</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="header">
    <h2>Add New Arrival</h2>
    <a href="new_arrival.php" class="back-btn">Back to New Arrivals</a>
</div>

<form action="add_new_arrival.php" method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required>

    <label for="image">Image:</label>
    <input type="file" id="image" name="image" accept="image/*" required>

    <button type="submit">Add New Arrival</button>
</form>

</body>
</html>
