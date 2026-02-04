<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "admindb", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only handle POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if an admin already exists
    $checkAdmin = $conn->query("SELECT COUNT(*) AS total FROM admin");
    $row = $checkAdmin->fetch_assoc();

    if ($row['total'] >= 1) {
        echo "<script>alert('Admin account already exists! Only one admin is allowed.'); window.location='alogin.html';</script>";
        exit();
    }

    // Get & sanitize inputs
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $gender = $_POST["gender"];

    // ✅ Full name validation - only characters and spaces allowed
    if (!preg_match("/^[a-zA-Z ]+$/", $fullname)) {
        echo "<script>alert('Name must contain only letters and spaces.'); window.location='aregister.html';</script>";
        exit();
    }

    // ✅ Phone validation - Must start with 6-9 and be 10 digits
    if (!preg_match("/^[6-9][0-9]{9}$/", $phone)) {
        echo "<script>alert('Invalid phone number. Must start with 6-9 and be 10 digits.'); window.location='aregister.html';</script>";
        exit();
    }

    // ✅ Email validation
    if (!str_ends_with($email, "@gmail.com")) {
        echo "<script>alert('Email must be a @gmail.com address.'); window.location='aregister.html';</script>";
        exit();
    }

    // ✅ Ensure email is in lowercase
    if ($email !== strtolower($email)) {
        echo "<script>alert('Email must be in lowercase only.'); window.location='aregister.html';</script>";
        exit();
    }

    // ✅ Password match check
    if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match.'); window.location='aregister.html';</script>";
        exit();
    }

    // ✅ Password strength validation - At least 1 number, 1 special character, 1 uppercase and lowercase letter
    if (!preg_match('/^(?=.*[0-9])(?=.*[@#$%^&+=!])(?=.*[a-z])(?=.*[A-Z]).{6,20}$/', $password)) {
        echo "<script>alert('Password must be 6-20 characters, include at least 1 number, 1 special character, and both upper and lowercase letters.'); window.location='aregister.html';</script>";
        exit();
    }

    // Hash the password for secure storage
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert admin data into database
    $stmt = $conn->prepare("INSERT INTO admin (fullname, email, phone, password, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullname, $email, $phone, $hashedPassword, $gender);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location='alogin.html';</script>";
    } else {
        echo "<script>alert('Error during registration. Please try again.'); window.location='aregister.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
