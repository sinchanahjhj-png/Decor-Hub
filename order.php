<?php
$host = 'localhost';
$dbname = 'admindb';
$username = 'root';
$password = '';
$port = 3307;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all orders
    $ordersStmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
    $orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);

    $orderIds = array_column($orders, 'id');
    $items = [];

    if (count($orderIds)) {
        $inQuery = implode(',', array_fill(0, count($orderIds), '?'));
        $itemStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id IN ($inQuery)");
        $itemStmt->execute($orderIds);
        $itemsRaw = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($itemsRaw as $item) {
            $items[$item['order_id']][] = $item;
        }
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            padding: 30px;
            margin: 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
        }
        .order {
            background: white;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .order h3 {
            margin-top: 0;
            font-size: 18px;
        }
        .order p {
            margin: 6px 0;
        }
        .items {
            margin-top: 15px;
        }
        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            background: #fafafa;
            padding: 10px;
            border-radius: 6px;
        }
        .order-item img {
            width: 80px;
            height: auto;
            margin-right: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .cancel-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }
        .cancelled-button {
            background-color: #ccc;
            color: black;  /* Changed to black for "Cancelled" text */
            border: none;
            padding: 8px 12px;
            cursor: not-allowed;
            margin-top: 10px;
            border-radius: 5px;
        }
        .cancel-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .cancel-modal-content {
            background-color: white;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
        }
        .cancel-modal-content input, .cancel-modal-content textarea, .cancel-modal-content button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }
    </style>
</head>
<body>

<a href="menu.html" style="display: inline-block; margin-bottom: 20px; text-decoration: none; background: #007BFF; color: white; padding: 10px 20px; border-radius: 5px;">← Back to Menu</a>

<h1>🧾 All Orders</h1>

<?php if (empty($orders)): ?>
    <p>No orders found.</p>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <div class="order" id="order-<?= $order['id']; ?>">
            <h3>Order #<?= $order['id']; ?> – <?= date("d M Y, h:i A", strtotime($order['created_at'])); ?></h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($order['name']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['email']); ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']); ?></p>

            <div class="items">
                <h4>Items:</h4>
                <?php if (!empty($items[$order['id']])): ?>
                    <?php foreach ($items[$order['id']] as $item): ?>
                        <div class="order-item">
                            <img src="<?= htmlspecialchars($item['image'] ?? 'images/no-image.png'); ?>" alt="<?= htmlspecialchars($item['name'] ?? 'Unnamed'); ?>">
                            <div>
                                <strong><?= htmlspecialchars($item['name'] ?? 'Unnamed'); ?></strong><br>
                                ₹<?= number_format($item['price'], 2); ?> × <?= $item['quantity']; ?>
                            </div>
                            <?php if ($order['status'] !== 'cancelled'): ?>
                                <button class="cancel-button" data-order-id="<?= $order['id']; ?>" data-phone="<?= $order['phone']; ?>" data-name="<?= htmlspecialchars($order['name']); ?>">Cancel</button>
                            <?php else: ?>
                                <button class="cancelled-button" disabled>Cancelled</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No items for this order.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Modal for Cancellation -->
<div id="cancelModal" class="cancel-modal">
    <div class="cancel-modal-content">
        <h2>Cancel Order</h2>
        <p><strong>Name:</strong> <span id="modalName"></span></p>
        <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
        <textarea id="reason" placeholder="Reason for cancellation..." rows="4"></textarea>
        <button id="submitCancelBtn">Cancel Order</button>
        <button id="closeCancelModal">Close</button>
    </div>
</div>

<script>
    const cancelButtons = document.querySelectorAll('.cancel-button');
    const cancelModal = document.getElementById('cancelModal');
    const modalName = document.getElementById('modalName');
    const modalPhone = document.getElementById('modalPhone');
    const reasonInput = document.getElementById('reason');
    const closeCancelModal = document.getElementById('closeCancelModal');
    const submitCancelBtn = document.getElementById('submitCancelBtn');

    cancelButtons.forEach(button => {
        button.addEventListener('click', () => {
            const orderId = button.getAttribute('data-order-id');
            const phone = button.getAttribute('data-phone');
            const name = button.getAttribute('data-name');

            modalName.textContent = name;
            modalPhone.textContent = phone;
            cancelModal.style.display = 'flex';

            submitCancelBtn.onclick = async () => {
                const reason = reasonInput.value.trim();

                if (!reason) {
                    alert("Please provide a reason for cancellation.");
                    return;
                }

                // Send cancellation request to backend
                try {
                    const res = await fetch('cancel_order.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ orderId, reason, phone })
                    });
                    const result = await res.json();

                    if (result.success) {
                        // Update button to "Cancelled"
                        const orderDiv = document.getElementById('order-' + orderId);
                        const cancelBtn = orderDiv.querySelector('.cancel-button');
                        cancelBtn.innerText = "Cancelled";
                        cancelBtn.classList.remove('cancel-button');
                        cancelBtn.classList.add('cancelled-button');
                        cancelBtn.disabled = true;

                        alert("Order cancelled! Your money will be returned to the registered phone number within 2 days.");
                    } else {
                        alert("Failed to cancel the order.");
                    }

                    cancelModal.style.display = 'none';
                } catch (err) {
                    alert("Error cancelling order.");
                }
            };
        });
    });

    closeCancelModal.onclick = () => {
        cancelModal.style.display = 'none';
    };
</script>

</body>
</html>
