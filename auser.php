<?php
include 'udb.php'; // Include your database connection

// Fetch all users
$query = "SELECT * FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - User Management</title>
  <link rel="stylesheet" href="admin.css"> <!-- Optional: your CSS file -->

  <style>
    /* Position the Back button at the top-right corner */
    .back-btn {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #007BFF;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-size: 16px;
    }

    .back-btn:hover {
      background-color: #0056b3;
    }

    /* Style the table */
    table {
      width: 100%;
      margin-top: 50px; /* Adjust table positioning so the button doesn't overlap */
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f4f4f4;
    }

    h1 {
      text-align: center;
      margin-top: 50px;
    }
  </style>
</head>
<body>

  <!-- Back Button -->
  <a href="adashboard.html" class="back-btn">Back to Dashboard</a>

  <h1>Manage Users</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Created At</th>
        <th>Is Logged In</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { 
        // Map gender (0 => Male, 1 => Female)
        $gender = $row['gender'] == 0 ? 'Male' : 'Female';
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['fullname']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= $gender ?></td> <!-- Display mapped gender -->
          <td><?= $row['created_at'] ?></td>
          <td><?= $row['is_logged_in'] ? 'Yes' : 'No' ?></td>
          <td>
            <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

</body>
</html>
