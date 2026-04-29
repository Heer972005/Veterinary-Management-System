<?php 
include '../includes/auth.php';
include '../config/db.php';
include '../includes/header.php';

$orderID = $_GET['id'];

// Get order
$order = $conn->query("
    SELECT o.*, u.userName
    FROM orders o
    JOIN users u ON o.userID = u.userID
    WHERE o.orderID = $orderID
")->fetch_assoc();

// Get items
$items = $conn->query("
    SELECT oi.*, p.proName
    FROM orderItems oi
    JOIN products p ON oi.productID = p.productID
    WHERE oi.orderID = $orderID
");
?>

<div class="container mt-5">
    <h2>Invoice 🧾</h2>

    <p><b>Order ID:</b> <?= $order['orderID'] ?></p>
    <p><b>Name:</b> <?= $order['userName'] ?></p>
    <p><b>Date:</b> <?= $order['orderDate'] ?></p>

    <table class="table table-bordered">
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>

        <?php while($i = $items->fetch_assoc()) { ?>
        <tr>
            <td><?= $i['proName'] ?></td>
            <td><?= $i['quantity'] ?></td>
            <td><?= $i['price'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <h4>Total: ₹<?= $order['totalAmt'] ?></h4>

    <a href="invoicePDF.php?id=<?= $orderID ?>" class="btn btn-primary">
        Download PDF
    </a>
</div>

<?php include '../includes/footer.php'; ?>