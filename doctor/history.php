<?php
include '../config/db.php';

// ✅ Check parameter
if (!isset($_GET['pet'])) {
    echo "<h3>No pet selected</h3>";
    exit();
}

$petID = $_GET['pet'];

// ✅ Query
$result = $conn->query("
    SELECT * FROM appointments 
    WHERE petID = $petID 
    ORDER BY appointmentDate DESC
");

echo "<div class='container mt-5'>";
echo "<h3>Patient History 🐾</h3>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card p-3 mb-2'>
                Date: {$row['appointmentDate']}<br>
                Status: {$row['appointmentStatus']}
              </div>";
    }
} else {
    echo "<p>No history found</p>";
}

echo "</div>";
?>