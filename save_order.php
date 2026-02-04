<?php
// Set headers
header('Content-Type: application/json');

// DB config
$host = 'localhost';
$dbname = 'admindb';
$username = 'root';
$password = '';
$port = 3307;

try {
    // Connect to DB
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read JSON input
    $input = json_decode(file_get_contents("php://input"), true);

    // Validate input
    if (
        empty($input['name']) || 
        empty($input['email']) || 
        empty($input['phone']) || 
        empty($input['items']) || 
        !is_array($input['items'])
    ) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
        exit;
    }

    // Insert into orders table
    $orderStmt = $pdo->prepare("INSERT INTO orders (name, email, phone, created_at) VALUES (?, ?, ?, NOW())");
    $orderStmt->execute([$input['name'], $input['email'], $input['phone']]);
    $orderId = $pdo->lastInsertId();

    // Insert each item into order_items
    $itemStmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, name, price, quantity, image, category)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($input['items'] as $item) {
        // Set default values for missing data
        $itemId = isset($item['id']) ? $item['id'] : 0;
        $name = isset($item['name']) ? $item['name'] : 'Unknown';
        $price = isset($item['price']) ? $item['price'] : 0.0;
        $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
        $image = isset($item['image']) ? $item['image'] : '';
        $category = isset($item['category']) ? $item['category'] : 'Unknown';

        // Check if the necessary fields are valid
        if ($itemId <= 0 || empty($name) || $price <= 0 || $quantity <= 0) {
            echo json_encode(['success' => false, 'error' => 'Invalid item data for one of the products.']);
            exit;
        }

        // Insert item into the order_items table
        $itemStmt->execute([
            $orderId,
            $itemId,
            $name,
            $price,
            $quantity,
            $image,
            $category
        ]);
    }

    echo json_encode(['success' => true, 'order_id' => $orderId]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
