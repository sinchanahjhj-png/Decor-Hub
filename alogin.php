<?php
// Start session at the very top, before ANYTHING else
session_start();

// Show errors (for debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database config
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admindb";
$port = 3307;

// Connect
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if login form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and check if email exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['fullname'];

            // Redirect to dashboard
            header("Location: adashboard.html");
            exit();
        } else {
            // Wrong password
            echo "<script>alert('Incorrect password.'); window.location.href='alogin.html';</script>";
            exit();
        }
    } else {
        // Admin not found
        echo "<script>alert('Admin account not found.'); window.location.href='alogin.html';</script>";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
