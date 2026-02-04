<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'admindb';
$username = 'root';
$password = '';
$port = 3307;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

$stmt = $pdo->query("SELECT * FROM new_arrivals");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Arrivals</title>
    <link rel="stylesheet" href="s.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
    <button onclick="window.location.href='menu.html';">Back</button>
    <div id="cartIcon" class="cart-icon">
        🛒 <span id="cartCount">0</span>
    </div>
</header>

<main>
    <div class="product-menu">
        <h1>New Arrivals</h1>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="images/new_arrivals/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100" />
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>₹<?php echo number_format($product['price'], 2); ?></p>
                    <button 
                        class="add-to-cart"
                        data-id="<?php echo $product['id']; ?>"
                        data-name="<?php echo htmlspecialchars($product['name']); ?>"
                        data-price="<?php echo $product['price']; ?>"
                        data-image="images/new_arrivals/<?php echo $product['image']; ?>"
                    >Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<!-- Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <h2>Your Cart</h2>
    <ul id="cartItems"></ul>
    <p><span id="totalPrice">Total: ₹0.00</span></p>
    <button id="checkoutBtn">Buy Now</button>
    <button id="closeCartBtn">Close</button> 
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="payment-modal" style="display: none;">
    <div class="payment-modal-content">
        <span class="close" id="closePaymentModal">&times;</span>
        <h2>Enter Card & Contact Details</h2>

        <label for="userName">Full Name:</label><br>
        <input type="text" id="userName" placeholder="Your Name"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" placeholder="Your Email"><br><br>

        <label for="phone">Phone Number:</label><br>
        <input type="tel" id="phone" placeholder="Your Phone" maxlength="10" minlength="10" pattern="\d{10}" required><br><br>

        <label for="cardNumber">Card Number:</label><br>
        <input type="text" id="cardNumber" maxlength="16" placeholder="Enter Your 16 digit card number"><br><br>

        <label for="expiry">Expiry Date (MM/YY):</label><br>
        <input type="text" id="expiry" placeholder="MM/YY"><br><br>

        <button id="payWithCardBtn">Pay Now</button>
    </div>
</div>

<script>
// Functions for updating cart and quantity
function toggleCartSidebar() {
    const sidebar = document.getElementById('cartSidebar');
    sidebar.classList.toggle('open');
    updateCartSidebar();
}

function updateCartCount() {
    const cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById('cartCount').textContent = totalItems;
}

function updateCartSidebar() {
    const cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    const container = document.getElementById('cartItems');
    container.innerHTML = '';
    let total = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;
        const li = document.createElement('li');
        li.innerHTML = `
            <img src="${item.image}" width="50"> ${item.name} - ₹${item.price}
            <button class="remove-item" data-id="${item.id}">Delete</button>
            <button class="decrease-item" data-id="${item.id}">-</button>
            <span>Qty: ${item.quantity}</span>
            <button class="increase-item" data-id="${item.id}">+</button>
        `;
        container.appendChild(li);
    });

    document.getElementById('totalPrice').textContent = `Total: ₹${total.toLocaleString()}`;

    document.querySelectorAll('.increase-item').forEach(btn => {
        btn.onclick = () => updateQuantity(btn.dataset.id, 1);
    });
    document.querySelectorAll('.decrease-item').forEach(btn => {
        btn.onclick = () => updateQuantity(btn.dataset.id, -1);
    });
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.onclick = () => removeFromCart(btn.dataset.id);
    });
}

function addToCart(id, name, price, image) {
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    const item = cart.find(p => p.id === id);
    if (item) {
        alert("Item already in cart.");
    } else {
        cart.push({ id, name, price, image, quantity: 1 });
        sessionStorage.setItem('cart', JSON.stringify(cart));
        updateCartSidebar();
        updateCartCount();
        alert("Item added to cart!");
    }
}

function updateQuantity(id, change) {
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    const item = cart.find(p => p.id === id);
    if (!item) return;

    item.quantity += change;
    if (item.quantity <= 0) {
        removeFromCart(id);
    } else {
        sessionStorage.setItem('cart', JSON.stringify(cart));
        updateCartSidebar();
    }
}

function removeFromCart(id) {
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    cart = cart.filter(p => p.id !== id);
    sessionStorage.setItem('cart', JSON.stringify(cart));
    updateCartSidebar();
    updateCartCount();
}

// Checkout Button Click
document.getElementById('checkoutBtn').onclick = () => {
    document.getElementById('paymentModal').style.display = 'block';
};

// Close modal
document.getElementById('closePaymentModal').onclick = () => {
    document.getElementById('paymentModal').style.display = 'none';
};

// Payment and Order Submission
document.getElementById('payWithCardBtn').onclick = () => {
    const name = document.getElementById('userName').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const cardNumber = document.getElementById('cardNumber').value.trim();
    const expiry = document.getElementById('expiry').value.trim();

    const namePattern = /^[a-zA-Z\s]+$/;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^[6-9]\d{9}$/;
    const cardPattern = /^\d{16}$/;
    const expiryPattern = /^(0[1-9]|1[0-2])\/\d{2}$/;

    if (!namePattern.test(name)) return alert("Please enter a valid name.");
    if (!emailPattern.test(email)) return alert("Please enter a valid email address.");
    if (!phonePattern.test(phone)) return alert("phone number starts with digits 6 to 9 and is exactly 10 digits");
    if (!cardPattern.test(cardNumber)) return alert("Card number must be exactly 16 digits.");
    if (!expiryPattern.test(expiry)) return alert("Expiry must be in MM/YY format.");

    const [inputMonth, inputYear] = expiry.split('/').map(Number);
    const now = new Date();
    const currentMonth = now.getMonth() + 1;
    const currentYear = parseInt(now.getFullYear().toString().slice(-2));

    if (inputYear < currentYear || (inputYear === currentYear && inputMonth < currentMonth)) {
        return alert("Card has expired.");
    }

    const cart = JSON.parse(sessionStorage.getItem('cart')) || [];

    const orderData = {
        name,
        email,
        phone,
        items: cart
    };

    fetch('save_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("order placed successfully...!");
            sessionStorage.removeItem('cart');
            updateCartSidebar();
            updateCartCount();
            document.getElementById('paymentModal').style.display = 'none';
            window.location.href = 'menu.html';
        } else {
            alert("Error saving order: " + data.error);
        }
    })
    .catch(err => {
        alert("Network error: " + err.message);
    });
};

// Add to Cart buttons
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.onclick = () => {
        const id = button.dataset.id;
        const name = button.dataset.name;
        const price = parseFloat(button.dataset.price);
        const image = button.dataset.image;
        addToCart(id, name, price, image);
    };
});

// Toggle cart sidebar
document.getElementById('cartIcon').onclick = toggleCartSidebar;
document.getElementById('closeCartBtn').onclick = toggleCartSidebar;

updateCartCount();
</script>

</body>
</html>
