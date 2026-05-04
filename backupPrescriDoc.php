<?php
include '../includes/auth.php';
include '../config/db.php';

$appointmentID = $_GET['id'];

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

    // EMAIL START

    $user = $conn->query("
        SELECT u.email, u.userName, p.petName
        FROM users u
        JOIN pets p ON u.userID = p.userID
        JOIN appointments a ON p.petID = a.petID
        WHERE a.appointmentID = $appointmentID
    ")->fetch_assoc();

    $to = $user['email'];
    $subject = "Pet Prescription Details";

    // HTML headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: vetclinic@gmail.com\r\n";

    // Build message
    $message = "<html><body>";
    $message .= "<h2>Prescription Details</h2>";
    $message .= "<p><b>Pet:</b> {$user['petName']}</p>";
    $message .= "<p><b>Notes:</b> {$notes}</p>";
    $message .= "<h4>Medicines:</h4><ul>";

    $items = $conn->query("
        SELECT pi.*, prd.proName 
        FROM prescriptionItems pi
        JOIN products prd ON pi.productID = prd.productID
        WHERE pi.prescriptionID = $prescriptionID
    ");

    while ($i = $items->fetch_assoc()) {
        $message .= "<li>{$i['proName']} - Qty: {$i['quantity']}</li>";
    }

    $message .= "</ul>";
    $message .= "<p>Thank you for visiting our clinic</p>";
    $message .= "</body></html>";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('Prescription saved + email sent'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Prescription saved but email failed'); window.location='dashboard.php';</script>";
    }

    // EMAIL END
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h2>Add Prescription </h2>

    <form method="POST">

        <textarea name="notes" class="form-control mb-3" placeholder="Doctor Notes"></textarea>

        <h5>Select Medicines:</h5>

        <?php
        $products = $conn->query("SELECT * FROM products");

        while ($p = $products->fetch_assoc()) {
            echo "
                <div class='mb-2'>
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