<?php
include 'udb.php';

if (!isset($_GET['id'])) {
  die("User ID not specified.");
}

$id = (int)$_GET['id'];

// Delete the user
$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: auser.php");
exit();
?>
