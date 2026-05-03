<?php  
include '../config/db.php';
include '../includes/header.php'; 
?>

<?php
// ================= ADD TO CART =================
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

    <!-- ================= FILTER FORM ================= -->
    <form method="GET" class="row mb-4">

        <!-- CATEGORY -->
        <div class="col-md-3">
            <select name="cat" class="form-control">
                <option value="">All Categories</option>

                <?php
                $cats = $conn->query("SELECT * FROM categories");
                while ($c = $cats->fetch_assoc()) {
                    $selected = (isset($_GET['cat']) && $_GET['cat'] == $c['catID']) ? 'selected' : '';
                    echo "<option value='{$c['catID']}' $selected>{$c['catName']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- MIN PRICE -->
        <div class="col-md-2">
            <input type="number" name="min" placeholder="Min Price" class="form-control"
                   value="<?php echo $_GET['min'] ?? ''; ?>">
        </div>

        <!-- MAX PRICE -->
        <div class="col-md-2">
            <input type="number" name="max" placeholder="Max Price" class="form-control"
                   value="<?php echo $_GET['max'] ?? ''; ?>">
        </div>

        <!-- SORT -->
        <div class="col-md-3">
            <select name="sort" class="form-control">
                <option value="">Sort By</option>
                <option value="low" <?= ($_GET['sort'] ?? '')=='low' ? 'selected' : '' ?>>Price Low → High</option>
                <option value="high" <?= ($_GET['sort'] ?? '')=='high' ? 'selected' : '' ?>>Price High → Low</option>
                <option value="name" <?= ($_GET['sort'] ?? '')=='name' ? 'selected' : '' ?>>Name A → Z</option>
            </select>
        </div>

        <!-- APPLY BUTTON -->
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Apply</button>
        </div>

    </form>

    <!-- ================= QUERY LOGIC ================= -->
    <?php
    $where = [];
    $order = "";

    // CATEGORY
    if (!empty($_GET['cat'])) {
        $cat = $_GET['cat'];
        $where[] = "catID = $cat";
    }

    // PRICE
    if (!empty($_GET['min'])) {
        $min = $_GET['min'];
        $where[] = "price >= $min";
    }

    if (!empty($_GET['max'])) {
        $max = $_GET['max'];
        $where[] = "price <= $max";
    }

    // SORT
    if (!empty($_GET['sort'])) {
        if ($_GET['sort'] == 'low') {
            $order = "ORDER BY price ASC";
        } elseif ($_GET['sort'] == 'high') {
            $order = "ORDER BY price DESC";
        } elseif ($_GET['sort'] == 'name') {
            $order = "ORDER BY proName ASC";
        }
    }

    // BUILD QUERY
    $condition = "";
    if (!empty($where)) {
        $condition = "WHERE " . implode(" AND ", $where);
    }

    $products = $conn->query("SELECT p.*, i.quantity AS stock
                            FROM products p
                            LEFT JOIN inventory i ON p.productID = i.productID");
    ?>

    <!-- ================= PRODUCTS ================= -->
    <div class="row">
        <?php
        if ($products->num_rows > 0) {
            while ($p = $products->fetch_assoc()) {
        ?>
            <div class="col-md-4">
                <div class="card p-3 mb-3 shadow">

                    <h5><?php echo $p['proName']; ?></h5>
                    <p>₹<?php echo $p['price']; ?></p>

                    <?php if ($p['stock'] <= 0) { ?>
                        <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                    <?php } else { ?>
                        <form method="POST">
                            <input type="hidden" name="productID" value="<?php echo $p['productID']; ?>">
                            <input type="number" name="qty" value="1" min="1" class="form-control mb-2">
                            <button name="addCart" class="btn btn-success w-100">Add to Cart</button>
                        </form>
                    <?php } ?>

                </div>
            </div>
        <?php 
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>

</div>

<?php include '../includes/footer.php'; ?>