<?php 
include '../includes/auth.php'; 
include '../config/db.php';

$userID = $_SESSION['userID'];

// Get cart
$cart = $conn->query("SELECT * FROM cart WHERE userID=$userID");
$cartID = $cart->fetch_assoc()['cartID'];

// Calculate total
$items = $conn->query("
    SELECT ci.*, p.price 
    FROM cart_items ci
    JOIN products p ON ci.productID = p.productID
    WHERE ci.cartID = $cartID
");

$total = 0;

while ($i = $items->fetch_assoc()) {
    $total += $i['price'] * $i['quantity'];
}

// Create order
$conn->query("
    INSERT INTO orders(userID, orderDate, totalAmt, orderStatus)
    VALUES($userID, CURDATE(), $total, 'Placed')
");

$orderID = $conn->insert_id;

// Insert order items
$items = $conn->query("SELECT * FROM cart_items WHERE cartID=$cartID");

while ($i = $items->fetch_assoc()) {

    $conn->query("
        INSERT INTO orderItems(orderID, productID, quantity, price)
        VALUES($orderID, {$i['productID']}, {$i['quantity']}, 0)
    ");
}

// Clear cart
$conn->query("DELETE FROM cart_items WHERE cartID=$cartID");

echo "<script>alert('Order Placed'); window.location='orders.php';</script>";
?>