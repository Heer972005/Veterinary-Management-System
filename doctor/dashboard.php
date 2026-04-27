<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 
?>

<div class="container mt-5">
    <h2>Doctor Dashboard 👨‍⚕️</h2>

    <h4>Appointments</h4>

    <?php
    $result = $conn->query("
        SELECT a.*, p.petName, u.userName 
        FROM appointments a
        JOIN pets p ON a.petID = p.petID
        JOIN users u ON p.userID = u.userID
        WHERE a.appointmentStatus = 'Pending'
    ");

    while ($row = $result->fetch_assoc()) {
        echo "<div class='card p-3 mb-3'>
                <b>Pet:</b> {$row['petName']} <br>
                <b>Owner:</b> {$row['userName']} <br>
                <b>Date:</b> {$row['appointmentDate']} <br>

                <a href='prescription.php?id={$row['appointmentID']}' 
                   class='btn btn-primary mt-2'>Add Prescription</a>
              </div>";
    }
    ?>

</div>

<?php include '../includes/footer.php'; ?>