<?php
include '../config/db.php';

$spec = $_GET['spec'];

// DEBUG (remove later)
// echo $spec;

$docs = $conn->query("
    SELECT d.doctorID, u.userName 
    FROM doctors d
    JOIN users u ON d.userID = u.userID
    WHERE d.specialization = '$spec'
    AND d.status = 'Approved'
");

echo "<option value=''>Select Doctor</option>";

while ($d = $docs->fetch_assoc()) {
    echo "<option value='{$d['doctorID']}'>{$d['userName']}</option>";
}
?>