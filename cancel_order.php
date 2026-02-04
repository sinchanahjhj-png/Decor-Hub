<?php
// cancel_order.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $orderId = $data['orderId'];
    $reason = $data['reason'];
    $phone = $data['phone'];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=admindb;port=3307", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the order status to 'cancelled' and save the cancellation reason
        $stmt = $pdo->prepare("UPDATE orders SET status = 'cancelled', cancellation_reason = ? WHERE id = ?");
        $stmt->execute([$reason, $orderId]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Order not found or already cancelled']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
