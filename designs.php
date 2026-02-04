<?php 
// DB Config
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "admindb";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category = $_GET['category'] ?? 'kitchen';
$categoryTitle = ucfirst($category);

$folderMap = [
    'kitchen' => 'kitchen_img',
    'bedroom' => 'bedroom_img',
    'living' => 'living_img',
    'bathroom' => 'bathroom_img',
    'prayer' => 'pr_img'
];
$imageFolder = $folderMap[$category] ?? 'kitchen_img';

$query = "SELECT id, name, price, description, image_path FROM designs WHERE category = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$designs = [];
while ($row = $result->fetch_assoc()) {
    $row['image_path'] = "images/{$imageFolder}/" . $row['image_path'];
    $designs[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($categoryTitle) ?> Designs</title>
    <link rel="stylesheet" href="puja.css">
    <style>
        .payment-modal {
            position: fixed;
            display: none;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .payment-modal-content {
            background: white;
            padding: 20px;
            width: 350px;
            border-radius: 10px;
            position: relative;
        }
        .payment-modal-content .close {
            position: absolute;
            top: 10px; right: 10px;
            font-size: 20px;
            cursor: pointer;
        }
        input, button {
            width: 100%; padding: 10px; margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="title">Explore Our Premium <?= htmlspecialchars($categoryTitle) ?> Designs</h3>
    <div class="products-container">
        <?php foreach ($designs as $d): ?>
            <div class="product" data-id="<?= $d['id'] ?>" data-name="<?= htmlspecialchars($d['name']) ?>" data-price="<?= $d['price'] ?>" data-image="<?= $d['image_path'] ?>" data-category="<?= $category ?>">
                <img src="<?= htmlspecialchars($d['image_path']) ?>" alt="<?= htmlspecialchars($d['name']) ?>" />
                <h3><?= htmlspecialchars($d['name']) ?></h3>
                <div class="price">&#8377; <?= number_format($d['price'], 2) ?></div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="payment-modal">
    <div class="payment-modal-content">
        <span class="close" id="closePaymentModal">&times;</span>
        <h2>Enter Details</h2>
        <input type="text" id="userName" placeholder="Your Name" autocapitalize="off" autocomplete="name">
        <input type="email" id="email" placeholder="Your Email" autocomplete="email">
        <input type="tel" id="phone" placeholder="Your Phone">
        <input type="text" id="cardNumber" placeholder="Card Number (16 digits)">
        <input type="text" id="expiry" placeholder="Expiry Date (MM/YY)">
        <button id="payWithCardBtn">Pay Now</button>
    </div>
</div>

<script>
let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

// Add to cart
document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', function () {
        const product = this.closest('.product');
        const id = product.dataset.id;
        const name = product.dataset.name;
        const price = parseFloat(product.dataset.price);
        const image = product.dataset.image;
        const category = product.dataset.category;

        if (cart.find(item => item.id === id)) {
            alert("Item already in cart.");
            return;
        }

        cart.push({ id, name, price, quantity: 1, image, category });
        sessionStorage.setItem('cart', JSON.stringify(cart));
        alert("Item added to cart.");
    });
});

// Show modal on image click
document.querySelectorAll('.product img').forEach(img => {
    img.addEventListener('click', () => {
        document.getElementById('paymentModal').style.display = 'flex';
    });
});

document.getElementById('closePaymentModal').onclick = () => {
    document.getElementById('paymentModal').style.display = 'none';
};

// Input restrictions
document.getElementById('userName').addEventListener('input', function () {
    this.value = this.value.replace(/[^A-Za-z\s]/g, '');
});

// Do not alter email case
document.getElementById('email').addEventListener('input', function () {
    // No lowercase enforcement
});

document.getElementById('phone').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 10);
});
document.getElementById('cardNumber').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 16);
});

// Full Validation
document.getElementById('payWithCardBtn').onclick = async () => {
    const name = document.getElementById('userName').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const card = document.getElementById('cardNumber').value.trim();
    const expiry = document.getElementById('expiry').value.trim();

    const nameRegex = /^[A-Za-z\s]+$/;
    const emailRegex = /^[a-z0-9._%+-]+@gmail\.com$/;
    const phoneRegex = /^[6-9]\d{9}$/;
    const cardRegex = /^\d{16}$/;
    const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;

    if (!nameRegex.test(name)) return alert("Please enter a valid name.");
    if (!emailRegex.test(email)) return alert("Please enter a valid Gmail address.");
    if (!phoneRegex.test(phone)) return alert("Phone number must start with 6-9 and be 10 digits.");
    if (!cardRegex.test(card)) return alert("Card number must be exactly 16 digits.");
    if (!expiryRegex.test(expiry)) return alert("Expiry must be in MM/YY format.");

    const [expMonth, expYear] = expiry.split('/').map(Number);
    const now = new Date();
    const currentMonth = now.getMonth() + 1;
    const currentYear = Number(now.getFullYear().toString().slice(-2));

    if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
        return alert("Card has expired.");
    }

    if (cart.length === 0) {
        alert("Cart is empty.");
        return;
    }

    try {
        const res = await fetch('save_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, phone, items: cart })
        });
        const result = await res.json();
        if (result.success) {
            alert("Order placed successfully! Order ID: " + result.order_id);
            sessionStorage.removeItem('cart');
            window.location.href = 'order.php';
        } else {
            alert("Failed to place order: " + result.error);
        }
    } catch (err) {
        alert("Error submitting order.");
    }
};
</script>

</body>
</html>
