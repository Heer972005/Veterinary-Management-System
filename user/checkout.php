<?php
include '../includes/auth.php';
include '../config/db.php';

$userID = $_SESSION['userID'];

// Get cart
$cart = $conn->query("SELECT * FROM cart WHERE userID=$userID");

if ($cart->num_rows == 0) {
    echo "<script>alert('Cart is empty'); window.location='../shop.php';</script>";
    exit();
}

$cartID = $cart->fetch_assoc()['cartID'];

// Get cart items WITH price
$items = $conn->query("
    SELECT ci.*, p.price 
    FROM cart_items ci
    JOIN products p ON ci.productID = p.productID
    WHERE ci.cartID = $cartID
");

if ($items->num_rows == 0) {
    echo "<script>alert('Cart is empty'); window.location='../shop.php';</script>";
    exit();
}

// Calculate total
$total = 0;
$cartData = [];

while ($i = $items->fetch_assoc()) {
    $subtotal = $i['price'] * $i['quantity'];
    $total += $subtotal;
    $cartData[] = $i; // store for reuse
}

// Create order
$conn->query("
    INSERT INTO orders(userID, orderDate, totalAmt, orderStatus)
    VALUES($userID, CURDATE(), $total, 'Placed')
");

$orderID = $conn->insert_id;

// Insert order items (CORRECT PRICE)
foreach ($cartData as $i) {

    $conn->query("
        INSERT INTO orderItems(orderID, productID, quantity, price)
        VALUES($orderID, {$i['productID']}, {$i['quantity']}, {$i['price']})
    ");
}

// Clear cart
$conn->query("DELETE FROM cart_items WHERE cartID=$cartID");

// Redirect
echo "<script>
alert('Order Placed Successfully!');
window.location='invoicePDF.php?id=$orderID';
</script>";
?>