<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 
?>
    
<div class="container mt-5">
    <h2>My Orders 📦</h2>

    <?php
    $userID = $_SESSION['userID'];

    $orders = $conn->query("SELECT * FROM orders WHERE userID=$userID");

    while ($o = $orders->fetch_assoc()) {
        echo "<div class='card p-3 mb-2'>
                Order ID: {$o['orderID']}<br>
                Total: ₹{$o['totalAmt']}<br>
                Status: {$o['orderStatus']}
              </div>";
        echo "<a href='invoiceView.php?id={$o['orderID']}' class='btn btn-info'>View Invoice</a>";
    }
    
    ?>
</div>


<?php include '../includes/footer.php'; ?>