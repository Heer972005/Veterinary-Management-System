<?php
include '../includes/auth.php';
include '../config/db.php';
include '../includes/header.php';

$userID = $_SESSION['userID'];

// ACTION HANDLERS

// Decrease quantity
if (isset($_GET['decrease'])) {
    $id = (int) $_GET['decrease'];

    $item = $conn->query("SELECT quantity FROM cart_items WHERE cartItemID=$id")->fetch_assoc();

    if ($item['quantity'] > 1) {
        $conn->query("UPDATE cart_items SET quantity = quantity - 1 WHERE cartItemID=$id");
    } else {
        $conn->query("DELETE FROM cart_items WHERE cartItemID=$id");
    }

    header("Location: cart.php");
    exit();
}

// Increase quantity
if (isset($_GET['increase'])) {
    $id = (int) $_GET['increase'];

    $conn->query("UPDATE cart_items SET quantity = quantity + 1 WHERE cartItemID=$id");

    header("Location: cart.php");
    exit();
}

// Delete item completely
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $conn->query("DELETE FROM cart_items WHERE cartItemID=$id");

    header("Location: cart.php");
    exit();
}
?>

<main class="flex-grow-1">
    <div class="container mt-5">

        <h2 class="mb-4">My Cart</h2>

        <?php
        $cart = $conn->query("SELECT * FROM cart WHERE userID=$userID");

        if ($cart->num_rows > 0) {

            $cartID = $cart->fetch_assoc()['cartID'];

            $items = $conn->query("
            SELECT ci.*, p.proName, p.price, i.quantity AS stock
            FROM cart_items ci
            JOIN products p ON ci.productID = p.productID
            JOIN inventory i ON p.productID = i.productID
        ");


            if ($items->num_rows > 0) {

                $total = 0;
                ?>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle shadow-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($i = $items->fetch_assoc()) {
                                $subtotal = $i['price'] * $i['quantity'];
                                $total += $subtotal;
                                ?>

                                <tr>
                                    <td>
                                        <?php echo $i['proName']; ?>
                                    </td>
                                    <td>₹
                                        <?php echo $i['price']; ?>
                                    </td>
                                    <td>
                                        <?php echo $i['quantity']; ?>
                                    </td>
                                    <td>₹
                                        <?php echo $subtotal; ?>
                                    </td>

                                    <td>
                                        <a href="?decrease=<?php echo $i['cartItemID']; ?>" class="btn btn-warning btn-sm">−</a>
                                        <?php if ($i['quantity'] < $i['stock']): ?>
                                            <a href="?increase=<?php echo $i['cartItemID']; ?>" class="btn btn-success btn-sm">+</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>Max</button>
                                        <?php endif; ?>
                                        <a href="?delete=<?php echo $i['cartItemID']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Remove item completely?')">
                                            ❌
                                        </a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>

                <!-- TOTAL -->
                <div class="text-end mt-4">
                    <h4>Total: ₹
                        <?php echo $total; ?>
                    </h4>
                    <a href="checkout.php" class="btn btn-success mt-2">Proceed to Checkout</a>
                </div>

                <?php
            } else {
                echo "<div class='alert alert-info'>Your cart is empty</div>";
            }

        } else {
            echo "<div class='alert alert-info'>Your cart is empty</div>";
        }
        ?>

    </div>
</main>

<?php include '../includes/footer.php'; ?>