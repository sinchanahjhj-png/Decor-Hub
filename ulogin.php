
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "userdb";
$port = 3307;

$conn = new mysqli($host, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if user already exists
    $check = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // User exists - login
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            // Password correct - mark as logged in
            $update = $conn->prepare("UPDATE users SET is_logged_in = 1 WHERE id = ?");
            $update->bind_param("i", $user["id"]);
            $update->execute();

            echo "<script>alert('Login Successful'); window.location.href='menu.html';</script>";
        } else {
            echo "<script>alert('Incorrect password or email'); window.location.href='ulogin.html';</script>";
        }
    } else {
        echo "<script>alert('Email not exists, First register then Login.'); window.location.href='uregister.html';</script>";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>


