<?php
header('Content-Type: application/json');

// Database connection details
$adminConn = new mysqli("localhost", "root", "", "admindb", 3307);
$userConn = new mysqli("localhost", "root", "", "userdb", 3307);

// Check connections
if ($adminConn->connect_error || $userConn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Fetch data from userdb
$userQuery = $userConn->query("SELECT COUNT(*) AS total FROM users");
$users = $userQuery->fetch_assoc()['total'];

// Fetch data from admindb
$productQuery = $adminConn->query("SELECT COUNT(*) AS total FROM products");
$designQuery = $adminConn->query("SELECT COUNT(*) AS total FROM designs");
$arrivalQuery = $adminConn->query("SELECT COUNT(*) AS total FROM new_arrivals");
$orderQuery = $adminConn->query("SELECT COUNT(*) AS total FROM orders");

$data = [
    "users" => $users,
    "products" => $productQuery->fetch_assoc()['total'],
    "designs" => $designQuery->fetch_assoc()['total'],
    "newArrivals" => $arrivalQuery->fetch_assoc()['total'],
    "orders" => $orderQuery->fetch_assoc()['total']
];

// Close connections
$userConn->close();
$adminConn->close();

// Return data as JSON
echo json_encode($data);
?>
