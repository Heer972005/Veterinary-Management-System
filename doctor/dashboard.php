<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 
?>

<div class="container mt-5">
    <h2>Doctor Dashboard </h2>

<?php
//  GET doctorID FROM userID
$doctorUserID = $_SESSION['userID'];

$doc = $conn->query("SELECT doctorID FROM doctors WHERE userID = $doctorUserID");

if ($doc->num_rows == 0) {
    echo "<p class='text-danger'>Doctor profile not found!</p>";
    exit();
}

$doctor = $doc->fetch_assoc();
$doctorID = $doctor['doctorID'];
?>

<!-- PENDING -->
<h4 class="mt-4">Pending Appointments</h4>

<?php
$pending = $conn->query("
    SELECT a.*, p.petName, u.userName 
    FROM appointments a
    JOIN pets p ON a.petID = p.petID
    JOIN users u ON p.userID = u.userID
    WHERE a.doctorID = $doctorID 
    AND a.appointmentStatus = 'Pending'
    ORDER BY a.appointmentDate ASC
");

if ($pending->num_rows > 0) {
    while ($row = $pending->fetch_assoc()) {
        echo "
        <div class='card p-3 mb-2 shadow-sm'>
            <b>Pet:</b> {$row['petName']}<br>
            <b>Owner:</b> {$row['userName']}<br>
            <b>Date:</b> {$row['appointmentDate']}<br>

            <a href='prescription.php?id={$row['appointmentID']}' 
               class='btn btn-primary mt-2'>Treat</a>
        </div>";
    }
} else {
    echo "<p>No pending appointments</p>";
}
?>

<!-- COMPLETED -->
<h4 class="mt-4">Completed Appointments</h4>

<?php
$completed = $conn->query("
    SELECT a.*, p.petName, u.userName 
    FROM appointments a
    JOIN pets p ON a.petID = p.petID
    JOIN users u ON p.userID = u.userID
    WHERE a.doctorID = $doctorID 
    AND a.appointmentStatus = 'Completed'
    ORDER BY a.appointmentDate DESC
");

if ($completed->num_rows > 0) {
    while ($row = $completed->fetch_assoc()) {
        echo "
        <div class='card p-3 mb-2 shadow-sm'>
            <b>Pet:</b> {$row['petName']}<br>
            <b>Owner:</b> {$row['userName']}<br>
            <b>Date:</b> {$row['appointmentDate']}<br>

            <a href='history.php?pet={$row['petID']}' 
               class='btn btn-info mt-2'>View History</a>
        </div>";
    }
} else {
    echo "<p>No completed appointments</p>";
}
?>

</div>

<?php include '../includes/footer.php'; ?>