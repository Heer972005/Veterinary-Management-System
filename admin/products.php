<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 
?>
<?php

// ADD PRODUCT
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $catID = $_POST['catID'];

    $conn->query("
        INSERT INTO products(proName, catID, price, stock)
        VALUES('$name', $catID, $price, $stock)
    ");
    echo "<script>alert('Product Added'); window.location='products.php';</script>";
}


// UPDATE STOCK
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $newStock = $_POST['newStock'];

    $conn->query("
        UPDATE products 
        SET stock = $newStock 
        WHERE productID = $id
    ");

    echo "<script>alert('Stock Updated'); window.location='products.php';</script>";
}
?>

<div class="container mt-5">
    <h2>Manage Products 📦</h2>

    <!-- ADD PRODUCT -->
<form method="POST" class="mb-4">
    
    <!-- CATEGORY DROPDOWN -->
    <select name="catID" class="form-control mb-2" required>
        <option value="">Select Category</option>

        <?php
        $cats = $conn->query("SELECT * FROM categories");
        while ($c = $cats->fetch_assoc()) {
            echo "<option value='{$c['catID']}'>{$c['catName']}</option>";
        }
        ?>
    </select>

    <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>
    <input type="number" name="price" class="form-control mb-2" placeholder="Price" required>
    <input type="number" name="stock" class="form-control mb-2" placeholder="Stock" required>

    <button name="add" class="btn btn-primary">Add Product</button>
</form>

    <hr>

    <h4>All Products</h4>

    <?php
    $result = $conn->query("
        SELECT p.*, c.catName 
        FROM products p
        JOIN categories c ON p.catID = c.catID
    ");
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='card p-3 mb-2'>
            <b>{$row['proName']}</b><br>
            Category: {$row['catName']}<br>
            Price: ₹{$row['price']}<br>
            Stock: {$row['stock']}<br>
            <form method='POST' style='margin-top:10px;'>
                <input type='hidden' name='id' value='{$row['productID']}'>
                <input type='number' name='newStock' placeholder='Update Stock' class='form-control mb-2'>
                <button name='update' class='btn btn-warning btn-sm'>Update Stock</button>
            </form>
        </div>
        ";
    }
    ?>

</div>

<?php include '../includes/footer.php'; ?>