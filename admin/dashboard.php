<?php include '../includes/auth.php'; ?>
<?php include '../includes/header.php'; ?>
<a href="products.php" class="btn btn-info">Manage Products</a>
<div class="container mt-5">
    <h2>Welcome <?php echo $_SESSION['name']; ?> 👋</h2>
    <p>User Dashboard</p>
</div>

<?php include '../includes/footer.php'; ?>