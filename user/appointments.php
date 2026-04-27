<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 
?>
<?php
if (isset($_POST['book'])) {

    $petID = $_POST['petID'];
    $doctorID = $_POST['doctorID'];
    $date = $_POST['date'];

    // 🔍 Check if doctor already booked at same time
    $check = $conn->query("
    SELECT * FROM appointments 
    WHERE doctorID = $doctorID 
    AND appointmentDate = '$date'
    AND appointmentStatus != 'Cancelled'
");

    if ($check->num_rows > 0) {

        echo "<script>alert('Doctor already has an appointment at this time!');</script>";

    } else {

        $sql = "INSERT INTO appointments(petID, doctorID, appointmentDate, appointmentStatus)
                VALUES($petID, $doctorID, '$date', 'Pending')";

        $conn->query($sql);

        echo "<script>alert('Appointment Booked'); window.location='appointments.php';</script>";
    }
}

if (isset($_GET['cancel'])) {

    $id = $_GET['cancel'];

    $conn->query("
        UPDATE appointments 
        SET appointmentStatus = 'Cancelled' 
        WHERE appointmentID = $id
    ");

    echo "<script>alert('Appointment Cancelled'); window.location='appointments.php';</script>";
}

?>

<div class="container mt-5">
    <h2>Book Appointment 📅</h2>

    <form method="POST">

        <!-- SELECT PET -->
        <select name="petID" class="form-control mb-2" required>
            <option value="">Select Pet</option>
            <?php
            $userID = $_SESSION['userID'];
            $pets = $conn->query("SELECT * FROM pets WHERE userID=$userID");
            while ($p = $pets->fetch_assoc()) {
                echo "<option value='{$p['petID']}'>{$p['petName']}</option>";
            }
            ?>
        </select>

        <!-- SELECT DOCTOR -->
        <select name="doctorID" class="form-control mb-2" required>
            <option value="">Select Doctor</option>
            <?php
            $docs = $conn->query("SELECT * FROM doctors");
            while ($d = $docs->fetch_assoc()) {
                echo "<option value='{$d['doctorID']}'>Doctor ID: {$d['doctorID']}</option>";
            }
            ?>
        </select>

        <!-- DATE -->
        <input type="datetime-local" name="date" class="form-control mb-2" required>

        <button type="submit" name="book" class="btn btn-success">Book Appointment</button>
    </form>

    <hr>

    <h4>My Appointments</h4>

    <?php
    $result = $conn->query("
        SELECT a.*, p.petName 
        FROM appointments a
        JOIN pets p ON a.petID = p.petID
        WHERE p.userID = $userID
    ");
    
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card p-2 mb-2'>
        <b>{$row['petName']}</b><br>
        Date: {$row['appointmentDate']}<br>
        Status: {$row['appointmentStatus']}<br>";

        if ($row['appointmentStatus'] == 'Pending') {
            echo "<a href='appointments.php?cancel={$row['appointmentID']}' 
            class='btn btn-danger btn-sm mt-2'>Cancel</a>";
        }

echo "</div>";
    }
    ?>
    
</div>

<?php include '../includes/footer.php'; ?>