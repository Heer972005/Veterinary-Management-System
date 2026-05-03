<?php
include '../includes/auth.php';
include '../config/db.php';

$userID = $_SESSION['userID'];
$prescriptionID = $_GET['id'];

// Get cart
$cart = $conn->query("SELECT * FROM cart WHERE userID = $userID");

if ($cart->num_rows > 0) {
    $cartID = $cart->fetch_assoc()['cartID'];
} else {
    $conn->query("INSERT INTO cart(userID) VALUES($userID)");
    $cartID = $conn->insert_id;
}

// Get prescription items + stock
$items = $conn->query("
    SELECT pi.*, p.proName, i.quantity AS stock
    FROM prescriptionItems pi
    JOIN products p ON pi.productID = p.productID
    LEFT JOIN inventory i ON p.productID = i.productID
    WHERE pi.prescriptionID = $prescriptionID
");
$outOfStock = [];
$added = [];

while ($i = $items->fetch_assoc()) {
    $stock = $i['stock'] ?? 0;
    if ($i['stock'] >= $i['quantity']) {

        // Add to cart
        $conn->query("
            INSERT INTO cart_items(cartID, productID, quantity)
            VALUES($cartID, {$i['productID']}, {$i['quantity']})
            ON DUPLICATE KEY UPDATE quantity = quantity + {$i['quantity']}
        ");

        $added[] = $i['proName'];

    } else {
        $outOfStock[] = $i['proName'];
    }
}

// Prepare message
$msg = "";

if (!empty($added)) {
    $msg .= "Added: " . implode(", ", $added) . "\\n";
}

// if (!empty($outOfStock)) {
//     $msg .= "Out of Stock: " . implode(", ", $outOfStock);
// }
if (!empty($outOfStock)) {
    echo "<script>
        if(confirm('Some items are out of stock. Add available items?')) {
            window.location='cart.php';
        } else {
            window.location='prescriptions.php';
        }
    </script>";
} else {
    echo "<script>alert('All medicines added'); window.location='cart.php';</script>";
}
echo "<script>alert('$msg'); window.location='cart.php';</script>";