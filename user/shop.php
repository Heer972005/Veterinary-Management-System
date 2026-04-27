<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 
?>
<?php
if (isset($_POST['addCart'])) {

    $userID = $_SESSION['userID'];
    $productID = $_POST['productID'];
    $qty = $_POST['qty'];

    // Check if cart exists
    $cart = $conn->query("SELECT * FROM cart WHERE userID = $userID");

    if ($cart->num_rows > 0) {
        $cartData = $cart->fetch_assoc();
        $cartID = $cartData['cartID'];
    } else {
        $conn->query("INSERT INTO cart(userID) VALUES($userID)");
        $cartID = $conn->insert_id;
    }

    // Insert or update cart item
    $check = $conn->query("
        SELECT * FROM cart_items 
        WHERE cartID = $cartID AND productID = $productID
    ");

    if ($check->num_rows > 0) {
        $conn->query("
            UPDATE cart_items 
            SET quantity = quantity + $qty 
            WHERE cartID = $cartID AND productID = $productID
        ");
    } else {
        $conn->query("
            INSERT INTO cart_items(cartID, productID, quantity)
            VALUES($cartID, $productID, $qty)
        ");
    }

    echo "<script>alert('Added to Cart');</script>";
}
?>
<div class="container mt-5">
    <h2>Pet Shop 🛒</h2>

    <div class="row">
        <?php
        $products = $conn->query("SELECT * FROM products");

        while ($p = $products->fetch_assoc()) {
        ?>
            <div class="col-md-4">
                <div class="card p-3 mb-3 shadow">
                    <h5><?php echo $p['proName']; ?></h5>
                    <p>₹<?php echo $p['price']; ?></p>

                    <form method="POST">
                        <input type="hidden" name="productID" value="<?php echo $p['productID']; ?>">
                        <input type="number" name="qty" value="1" min="1" class="form-control mb-2">
                        <button name="addCart" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>