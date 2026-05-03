<?php
include '../includes/auth.php';
include '../config/db.php';

// ================= GET DOCTOR =================
$userID = $_SESSION['userID'];

$doc = $conn->query("SELECT doctorID FROM doctors WHERE userID = $userID")->fetch_assoc();
$doctorID = $doc['doctorID'];

// ================= DATE =================
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// ================= HEADERS =================
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Doctor_Report_$date.xls");

// ================= DATA =================
echo "Doctor Daily Report\n";
echo "Date: $date\n\n";

// APPOINTMENTS
$stats = $conn->query("
    SELECT 
        COUNT(*) AS total,
        SUM(CASE WHEN appointmentStatus='Completed' THEN 1 ELSE 0 END) AS completed,
        SUM(CASE WHEN appointmentStatus='Pending' THEN 1 ELSE 0 END) AS pending
    FROM appointments
    WHERE doctorID = $doctorID
    AND DATE(appointmentDate) = '$date'
")->fetch_assoc();

echo "Appointments\n";
echo "Total\tCompleted\tPending\n";
echo "{$stats['total']}\t{$stats['completed']}\t{$stats['pending']}\n\n";

// REVENUE
$revenue = $conn->query("
    SELECT SUM(totalAmt) AS totalRevenue
    FROM orders
    WHERE DATE(orderDate) = '$date'
")->fetch_assoc();

echo "Revenue\n";
echo "Total Revenue\n";
echo "{$revenue['totalRevenue']}\n\n";

// MEDICINE
$med = $conn->query("
    SELECT SUM(oi.quantity * p.price) AS medRevenue
    FROM orderItems oi
    JOIN products p ON oi.productID = p.productID
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.orderDate) = '$date'
")->fetch_assoc();

echo "Medicine Revenue\n";
echo "{$med['medRevenue']}\n\n";

// STOCK
$stock = $conn->query("
    SELECT SUM(oi.quantity) AS totalSold
    FROM orderItems oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.orderDate) = '$date'
")->fetch_assoc();

echo "Stock Used\n";
echo "{$stock['totalSold']}\n";
?>