<?php
session_start();

// Get the cart data from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);

// Update the session cart with the new cart data
if (isset($data['cart'])) {
    $_SESSION['cart'] = $data['cart'];
    echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>
