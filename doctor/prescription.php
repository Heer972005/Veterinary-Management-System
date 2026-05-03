<?php 
include '../includes/auth.php'; 
include '../config/db.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer-master/PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';
$appointmentID = $_GET['id'];
?>
<?php
if (isset($_POST['save'])) {

    $notes = $_POST['notes'];

    // 1. SAVE PRESCRIPTION
    $conn->query("
        INSERT INTO prescriptions(appointmentID, notes)
        VALUES($appointmentID, '$notes')
    ");

    $prescriptionID = $conn->insert_id;

    // 2. SAVE MEDICINES
    if (!empty($_POST['med'])) {
        foreach ($_POST['med'] as $productID) {

            $qty = $_POST['qty'][$productID];

            $conn->query("
                INSERT INTO prescriptionItems(prescriptionID, productID, quantity)
                VALUES($prescriptionID, $productID, $qty)
            ");
        }
    }

    // 3. UPDATE APPOINTMENT
    $conn->query("
        UPDATE appointments 
        SET appointmentStatus = 'Completed' 
        WHERE appointmentID = $appointmentID
    ");

    // EMAIL START


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'heermehta.126700@marwadiuniversity.ac.in'; // CHANGE
        $mail->Password = 'xwie orxh wdcz obav';   // CHANGE

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // GET USER
        $user = $conn->query("
            SELECT u.email, u.userName, p.petName
            FROM users u
            JOIN pets p ON u.userID = p.userID
            JOIN appointments a ON p.petID = a.petID
            WHERE a.appointmentID = $appointmentID
        ")->fetch_assoc();

        $mail->setFrom('heermehta.126700@marwadiuniversity.ac.in', 'PetCare Clinic');
        $mail->addAddress($user['email'], $user['userName']);

        $mail->isHTML(true);
        $mail->Subject = 'Your Pet Prescription';

        $body = "<h2>Prescription Details</h2>";
        $body .= "<p><b>Pet:</b> {$user['petName']}</p>";
        $body .= "<p><b>Notes:</b> {$notes}</p>";
        $body .= "<h4>Medicines:</h4><ul>";

        $items = $conn->query("
            SELECT pi.*, prd.proName 
            FROM prescriptionItems pi
            JOIN products prd ON pi.productID = prd.productID
            WHERE pi.prescriptionID = $prescriptionID
        ");

        while ($i = $items->fetch_assoc()) {
            $body .= "<li>{$i['proName']} - Qty: {$i['quantity']}</li>";
        }

        $body .= "</ul>";
        $body .= "<p>Take care 🐾</p>";

        $mail->Body = $body;

        $mail->send();

        echo "<script>alert('Prescription saved + Email sent'); window.location='dashboard.php';</script>";

    } catch (Exception $e) {
        echo "<script>alert('Saved but Email failed: {$mail->ErrorInfo}'); window.location='dashboard.php';</script>";
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



















