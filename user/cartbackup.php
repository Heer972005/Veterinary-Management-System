<div class="container mt-5">
    <h2>My Cart</h2>

    <?php
    $userID = $_SESSION['userID'];

    $cart = $conn->query("SELECT * FROM cart WHERE userID=$userID");

    if ($cart->num_rows > 0) {
        $cartID = $cart->fetch_assoc()['cartID'];

        $items = $conn->query("
            SELECT ci.*, p.proName, p.price 
            FROM cart_items ci
            JOIN products p ON ci.productID = p.productID
            WHERE ci.cartID = $cartID
        ");

        $total = 0;

        while ($i = $items->fetch_assoc()) {
            $subtotal = $i['price'] * $i['quantity'];
            $total += $subtotal;

            echo "<div class='card p-2 mb-2'>
                    {$i['proName']} - ₹{$i['price']} x {$i['quantity']} = ₹$subtotal
                  </div>";
        }

        echo "<h4>Total: ₹$total</h4>";
        echo "<a href='checkout.php' class='btn btn-success'>Checkout</a>";

    } else {
        echo "Cart is empty";
    }
    ?>
</div>