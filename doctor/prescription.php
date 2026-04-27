<?php 
include '../includes/auth.php'; 
include '../config/db.php';

$appointmentID = $_GET['id'];
?>
<?php
if (isset($_POST['save'])) {

    $notes = $_POST['notes'];

    // 1. Insert prescription
    $conn->query("
        INSERT INTO prescriptions(appointmentID, notes)
        VALUES($appointmentID, '$notes')
    ");

    $prescriptionID = $conn->insert_id;

    // 2. Insert medicines
    if (!empty($_POST['med'])) {
        foreach ($_POST['med'] as $productID) {

            $qty = $_POST['qty'][$productID];

            $conn->query("
                INSERT INTO prescriptionItems(prescriptionID, productID, quantity)
                VALUES($prescriptionID, $productID, $qty)
            ");
        }
    }

    // 3. Update appointment
    $conn->query("
        UPDATE appointments 
        SET appointmentStatus = 'Completed' 
        WHERE appointmentID = $appointmentID
    ");

    echo "<script>alert('Prescription Saved'); window.location='dashboard.php';</script>";
}
?>
<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h2>Add Prescription 💊</h2>

    <form method="POST">

        <textarea name="notes" class="form-control mb-3" placeholder="Doctor Notes"></textarea>

        <h5>Select Medicines:</h5>

        <?php
        $products = $conn->query("SELECT * FROM products");

        while ($p = $products->fetch_assoc()) {
            echo "
                <div>
                    <input type='checkbox' name='med[]' value='{$p['productID']}'>
                    {$p['proName']} (₹{$p['price']})
                    Qty: <input type='number' name='qty[{$p['productID']}]' value='1' min='1'>
                </div>
            ";
        }
        ?>

        <button type="submit" name="save" class="btn btn-success mt-3">
            Save Prescription
        </button>

    </form>
</div>

<?php include '../includes/footer.php'; ?>