<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 

// ================= GET doctorID =================
$userID = $_SESSION['userID'];

$doc = $conn->query("SELECT doctorID FROM doctors WHERE userID = $userID");

if ($doc->num_rows == 0) {
    echo "<p class='text-danger'>Doctor profile not found!</p>";
    exit();
}

$doctor = $doc->fetch_assoc();
$doctorID = $doctor['doctorID'];


// ================= DATE FILTER =================
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');


// ================= APPOINTMENTS =================
$stats = $conn->query("
    SELECT 
        COUNT(*) AS total,
        SUM(CASE WHEN appointmentStatus='Completed' THEN 1 ELSE 0 END) AS completed,
        SUM(CASE WHEN appointmentStatus='Pending' THEN 1 ELSE 0 END) AS pending
    FROM appointments
    WHERE doctorID = $doctorID
    AND DATE(appointmentDate) = '$date'
")->fetch_assoc();


// ================= TOTAL REVENUE =================
$revenue = $conn->query("
    SELECT SUM(totalAmt) AS totalRevenue
    FROM orders
    WHERE DATE(orderDate) = '$date'
")->fetch_assoc();


// ================= MEDICINE REVENUE =================
$med = $conn->query("
    SELECT SUM(oi.quantity * p.price) AS medRevenue
    FROM orderItems oi
    JOIN products p ON oi.productID = p.productID
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.orderDate) = '$date'
")->fetch_assoc();


// ================= STOCK USED =================
$stock = $conn->query("
    SELECT SUM(oi.quantity) AS totalSold
    FROM orderItems oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.orderDate) = '$date'
")->fetch_assoc();
?>

<div class="container mt-5">
    <h2>📊 Doctor Daily Report</h2>

    <!-- DATE FILTER -->
    <form method="GET" class="mb-4">
        <input type="date" name="date" value="<?php echo $date; ?>" class="form-control mb-2" required>
        <button class="btn btn-primary">View Report</button>
    </form>

    <!-- APPOINTMENTS -->
    <div class="card p-3 mb-3 shadow">
        <h4>Appointments</h4>
        <p>Total: <b><?php echo $stats['total'] ?? 0; ?></b></p>
        <p>Completed: <b><?php echo $stats['completed'] ?? 0; ?></b></p>
        <p>Pending: <b><?php echo $stats['pending'] ?? 0; ?></b></p>
    </div>

    <!-- REVENUE -->
    <div class="card p-3 mb-3 shadow">
        <h4>Revenue</h4>
        <p>Total Revenue: <b>₹<?php echo $revenue['totalRevenue'] ?? 0; ?></b></p>
        <p>Medicine Revenue: <b>₹<?php echo $med['medRevenue'] ?? 0; ?></b></p>
    </div>

    <!-- STOCK -->
    <div class="card p-3 shadow">
        <h4>Stock Usage</h4>
        <p>Items Sold Today: <b><?php echo $stock['totalSold'] ?? 0; ?></b></p>
    </div>
    <a href="exportReport.php?date=<?php echo $date; ?>" 
    class="btn btn-success mb-3">
    ⬇ Download Excel Report
    </a>
</div>

<?php include '../includes/footer.php'; ?>