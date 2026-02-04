<?php
// register.php

$host = "localhost";
$user = "root";
$password = "";
$db = "userdb";
$port = 3307;

// Create connection
$conn = new mysqli($host, $user, $password, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from form and sanitize inputs
$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$gender = $_POST['gender'];

// === Validation ===

// Fullname validation - only letters and spaces allowed
if (!preg_match("/^[a-zA-Z ]+$/", $fullname)) {
    echo "<script>
        alert('Name must contain only letters and spaces.');
        window.location='uregister.html';
    </script>";
    exit();
}

// Email must be lowercase
if ($email !== strtolower($email)) {
    echo "<script>
        alert('Email address must be in lowercase only.');
        window.location='uregister.html';
    </script>";
    exit();
}

// Check if email is valid and ends with @gmail.com
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, "@gmail.com")) {
    echo "<script>
        alert('Email must end with @gmail.com');
        window.location='uregister.html';
    </script>";
    exit();
}

// Check if phone number is valid (10 digits starting with 6-9)
// This allows the phone number to contain spaces, dashes, or parentheses
if (!preg_match('/^[6-9][0-9]{9}$/', preg_replace("/[^0-9]/", "", $phone))) {
    echo "<script>
        alert('Please enter a valid 10-digit phone number starting with 6, 7, 8, or 9.');
        window.location='uregister.html';
    </script>";
    exit();
}

// Password format validation
if (!preg_match('/^[A-Z][a-z]*[0-9@#]+[a-z0-9@#]*$/', $password)) {
    echo "<script>
        alert('Password must start with an uppercase letter, followed by lowercase letters, and contain at least one number or special character (@, #).');
        window.location='uregister.html';
    </script>";
    exit();
}

// Ensure it contains at least one digit
if (!preg_match('/[0-9]/', $password)) {
    echo "<script>
        alert('Password must contain at least one number.');
        window.location='uregister.html';
    </script>";
    exit();
}

// Ensure it contains at least one special character (@ or #)
if (!preg_match('/[@#]/', $password)) {
    echo "<script>
        alert('Password must contain at least one special character (@ or #).');
        window.location='uregister.html';
    </script>";
    exit();
}

// Password confirmation check
if ($password !== $cpassword) {
    echo "<script>
        alert('Passwords do not match!');
        window.location='uregister.html';
    </script>";
    exit();
}

// Check if email already exists
$sql = "SELECT id FROM users WHERE email = '$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<script>
        alert('Email already registered. Please login.');
        window.location.href = 'ulogin.html';
    </script>";
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into database (storing phone as entered)
$sql = "INSERT INTO users (fullname, email, phone, password, gender)
        VALUES ('$fullname', '$email', '$phone', '$hashed_password', '$gender')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
        alert('Registration Successful!');
        window.location.href = 'ulogin.html';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
