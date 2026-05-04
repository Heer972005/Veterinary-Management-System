<?php
include '../includes/auth.php';
include '../config/db.php';
include '../includes/header.php';
?>

<div class="container mt-5">
    <h2>My Prescriptions</h2>

    <?php
    $userID = $_SESSION['userID'];

    $result = $conn->query("
        SELECT pr.*, p.petName 
        FROM prescriptions pr
        JOIN appointments a ON pr.appointmentID = a.appointmentID
        JOIN pets p ON a.petID = p.petID
        WHERE p.userID = $userID
    ");
    while ($row = $result->fetch_assoc()) {

        echo "<div class='card p-3 mb-3'>
            <b>Pet:</b> {$row['petName']}<br>
            <b>Notes:</b> {$row['notes']}<br>";

        // Medicines
        $items = $conn->query("
        SELECT pi.*, prd.proName 
        FROM prescriptionItems pi
        JOIN products prd ON pi.productID = prd.productID
        WHERE pi.prescriptionID = {$row['prescriptionID']}
    ");

        while ($i = $items->fetch_assoc()) {
            echo "{$i['proName']} - Qty: {$i['quantity']}<br>";
        }

        // FIXED BUTTON
        echo "<a href='addPrescriptionCart.php?id={$row['prescriptionID']}'
            class='btn btn-warning mt-2'
            onclick=\"return confirm('Do you want to add these medicines to cart?')\">
            Buy Medicines
          </a>";

        echo "</div>";
    }
    ?>

</div>

<?php include '../includes/footer.php'; ?>