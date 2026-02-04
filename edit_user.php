<?php
include 'udb.php';

if (!isset($_GET['id'])) {
  die("User ID not specified.");
}

$id = (int)$_GET['id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  
  // Convert gender to 0 or 1 for database storage
  $gender = $_POST['gender'] === 'Male' ? 0 : 1;
  
  $is_logged_in = isset($_POST['is_logged_in']) ? 1 : 0;

  // Update the user in the database
  $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, phone=?, gender=?, is_logged_in=? WHERE id=?");
  $stmt->bind_param("sssisi", $fullname, $email, $phone, $gender, $is_logged_in, $id);
  $stmt->execute();

  header("Location: auser.php");
  exit();
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
</head>
<body>
  <h1>Edit User</h1>

  <form method="post">
    <label>Full Name:</label><br>
    <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required><br><br>

    <label>Gender:</label><br>
    <select name="gender" required>
      <option value="Male" <?= $user['gender'] === 0 ? 'selected' : '' ?>>Male</option>
      <option value="Female" <?= $user['gender'] === 1 ? 'selected' : '' ?>>Female</option>
    </select><br><br>

    <label>
      <input type="checkbox" name="is_logged_in" <?= $user['is_logged_in'] ? 'checked' : '' ?>>
      Is Logged In
    </label><br><br>

    <button type="submit">Update User</button>
  </form>

  <p><a href="auser.php">Back</a></p>
</body>
</html>
