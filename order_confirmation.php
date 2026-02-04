<?php
session_start();

// Retrieve order details from session
$orderDetails = isset($_SESSION['orderDetails']) ? $_SESSION['orderDetails'] : null;

if (!$orderDetails) {
    echo "No order found.";
    exit;
}

$orderDetails = json_decode($orderDetails, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        .order-summary {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .order-summary h2 {
            text-align: center;
        }

        .order-items {
            margin-top: 20px;
        }

        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .order-item img {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }

        .order-item .details {
            flex: 1;
        }

        .order-item .price {
            font-weight: bold;
            color: #3d9d7a;
        }

        .order-item .quantity {
            color: #555;
        }

        .order-details {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="order-summary">
    <h2>Order Confirmation</h2>
    <p>Thank you for your order, <?= htmlspecialchars($orderDetails['userName']) ?>!</p>

    <h3>Your Order Details:</h3>

    <div class="order-items">
        <?php foreach ($orderDetails['orderItems'] as $item): ?>
            <div class="order-item">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="details">
                    <h4><?= htmlspecialchars($item['name']) ?></h4>
                    <p class="quantity">Quantity: <?= $item['quantity'] ?></p>
                    <p class="price">Price: ₹<?= number_format($item['price'], 2) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="order-details">
        <p><strong>Name:</strong> <?= htmlspecialchars($orderDetails['userName']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($orderDetails['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($orderDetails['phone']) ?></p>
    </div>

    <div class="order-details">
        <h3>Total Amount: ₹<?= number_format(array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $orderDetails['orderItems'])), 2) ?></h3>
    </div>
</div>

</body>
</html>
