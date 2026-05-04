<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 
?>
<?php
$userID = $_SESSION['userID'];

// Get appointments within 1 hour and not yet notified
$reminder = $conn->query("
    SELECT a.*, p.petName 
    FROM appointments a
    JOIN pets p ON a.petID = p.petID
    WHERE p.userID = $userID
    AND a.appointmentStatus = 'Pending'
    AND a.reminderSent = 0
    AND a.appointmentDate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MINUTE)
");

while ($r = $reminder->fetch_assoc()) {

    //  SHOW ALERT (for demo)
    echo "<script>
        alert('Reminder: Appointment for {$r['petName']} within 1 hour!');
    </script>";

    //  OPTIONAL: SEND EMAIL/SMS HERE

    //  Mark as sent
    $conn->query("
        UPDATE appointments 
        SET reminderSent = 1 
        WHERE appointmentID = {$r['appointmentID']}
    ");
}
?>
<?php
if (isset($_POST['book'])) {

    $petID = $_POST['petID'];
    $doctorID = $_POST['doctorID'];
    $date = $_POST['date'];

    //  Check if doctor already booked at same time
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
    <h2>Book Appointment</h2>

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

        <!-- DATE -->
        <input type="datetime-local" name="date" class="form-control mb-2" id="dateInput" required>

        <select name="specialization" id="specialization" class="form-control mb-2">
            <option value="">What does your pet need?</option>
            <option value="General">General Checkup </option>
            <option value="Skin">Skin Problems </option>
            <option value="Surgery">Surgery </option>
            <option value="Vaccination">Vaccination </option>
        </select>
                <!-- SELECT DOCTOR -->
        <select name="doctorID" id="doctorList" class="form-control mb-2" required>
            <option value="">Select Doctor</option>
            <?php
            //$docs = $conn->query("
            //    SELECT d.doctorID, u.userName 
            //    FROM doctors d
            //    JOIN users u ON d.userID = u.userID
            //");
            //while ($d = $docs->fetch_assoc()) {
            //    echo "<option value='{$d['doctorID']}'>{$d['userName']} (ID: {$d['doctorID']})</option>";
            //}
            ?>
        </select>
        <button type="submit" name="book" class="btn btn-success">Book Appointment</button>
    </form>
    <script>
    let now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());

    document.getElementById("dateInput").min = now.toISOString().slice(0,16);
</script>
<hr>

<h4>Upcoming Appointments</h4>

<?php
$upcoming = $conn->query("
    SELECT a.*, p.petName 
    FROM appointments a
    JOIN pets p ON a.petID = p.petID
    WHERE p.userID = $userID 
    AND a.appointmentStatus = 'Pending'
");

if ($upcoming->num_rows > 0) {
    while ($row = $upcoming->fetch_assoc()) {
        echo "<div class='card p-2 mb-2'>
                <b>{$row['petName']}</b><br>
                Date: {$row['appointmentDate']}<br>
                Status: Pending<br>
                <a href='appointments.php?cancel={$row['appointmentID']}' 
                class='btn btn-danger btn-sm mt-2'>Cancel</a>
              </div>";
    }
} else {
    echo "<p>No upcoming appointments</p>";
}
?>

<hr>

<h4>Completed Appointments</h4>

<?php
$completed = $conn->query("
    SELECT a.*, p.petName 
    FROM appointments a
    JOIN pets p ON a.petID = p.petID
    WHERE p.userID = $userID 
    AND a.appointmentStatus = 'Completed'
");

if ($completed->num_rows > 0) {
    while ($row = $completed->fetch_assoc()) {
        echo "<div class='card p-2 mb-2'>
                <b>{$row['petName']}</b><br>
                Date: {$row['appointmentDate']}<br>
                Status: Completed
              </div>";
    }
} else {
    echo "<p>No completed appointments</p>";
}
?>

<hr>

<h4>Cancelled Appointments</h4>

<?php
$cancelled = $conn->query("
    SELECT a.*, p.petName 
    FROM appointments a
    JOIN pets p ON a.petID = p.petID
    WHERE p.userID = $userID 
    AND a.appointmentStatus = 'Cancelled'
");

if ($cancelled->num_rows > 0) {
    while ($row = $cancelled->fetch_assoc()) {
        echo "<div class='card p-2 mb-2'>
                <b>{$row['petName']}</b><br>
                Date: {$row['appointmentDate']}<br>
                Status: Cancelled
              </div>";
    }
}
?>
    ?>
    
</div>
<script>
document.getElementById("specialization").addEventListener("change", function () {

    let spec = this.value;
    console.log("Selected spec:", spec); 
    if (!spec) return;

    fetch("getDoctors.php?spec=" + encodeURIComponent(spec))
    .then(res => res.text())
    .then(data => {
        document.getElementById("doctorList").innerHTML = data;
    });
});
</script>
<?php include '../includes/footer.php'; ?>