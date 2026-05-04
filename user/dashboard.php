<?php
include '../includes/header.php';
include '../includes/auth.php';
include '../config/db.php';


// // LOGIN CHECK
// if (!isset($_SESSION['userID'])) {
//     header("Location: ../login.php");
//     exit();
// }

$userID = $_SESSION['userID'];
?>

<main class="flex-grow-1 d-flex align-items-center justify-content-center">

    <div class="container mt-0">

        <h2>Welcome,
            <?php echo $_SESSION['name']; ?>
        </h2>
        <div class="mt-3">
            <h4>Quick Actions</h4>

            <a href="pets.php" class="btn btn-primary m-2">My Pets</a>
            <a href="appointments.php" class="btn btn-success m-2">Book Appointment</a>
            <a href="../shop.php" class="btn btn-warning m-2">Shop Products</a>
            <a href="cart.php" class="btn btn-dark m-2">View Cart</a>
            <a href="orders.php" class="btn btn-danger m-2">View Orders</a>
        </div>
        <!-- STATS -->
        <div class="row mt-4 text-center">

            <?php
            $pets = $conn->query("
    SELECT COUNT(*) AS total 
    FROM pets 
    WHERE userID = $userID
")->fetch_assoc()['total'];

            $appointments = $conn->query("
    SELECT COUNT(*) AS total
    FROM appointments a
    JOIN pets p ON a.petID = p.petID
    WHERE p.userID = $userID
")->fetch_assoc()['total'];

            $orders = $conn->query("
    SELECT COUNT(*) AS total
    FROM orders 
    WHERE userID = $userID
")->fetch_assoc()['total'];
            ?>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>
                        <?php echo $pets; ?>
                    </h4>
                    <p>My Pets </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>
                        <?php echo $appointments; ?>
                    </h4>
                    <p>Appointments </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>
                        <?php echo $orders; ?>
                    </h4>
                    <p>Orders </p>
                </div>
            </div>

        </div>

        <!--  UPCOMING APPOINTMENTS -->
        <div class="mt-5">
            <h4>Upcoming Appointments </h4>

            <?php
            $apps = $conn->query("
            SELECT a.*, p.petName 
            FROM appointments a
            JOIN pets p ON a.petID = p.petID
            WHERE p.userID = $userID AND a.appointmentStatus = 'Pending'
            ORDER BY a.appointmentDate ASC
            LIMIT 3
        ");

            if ($apps->num_rows > 0) {
                while ($a = $apps->fetch_assoc()) {
                    ?>
                    <div class="card p-3 mb-2">
                        <b>
                            <?php echo $a['petName']; ?>
                        </b><br>
                        Date:
                        <?php echo $a['appointmentDate']; ?><br>
                        Status:
                        <?php echo $a['appointmentStatus']; ?>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No upcoming appointments</p>";
            }
            ?>
        </div>

        <!-- RECENT ORDERS -->
        <div class="mt-5">
            <h4>Recent Orders </h4>

            <?php
            $orders = $conn->query("
            SELECT * FROM orders 
            WHERE userID = $userID 
            ORDER BY orderID DESC 
            LIMIT 3
        ");

            if ($orders->num_rows > 0) {
                while ($o = $orders->fetch_assoc()) {
                    ?>
                    <div class="card p-3 mb-2">
                        Order #
                        <?php echo $o['orderID']; ?><br>
                        Amount: ₹
                        <?php echo $o['totalAmt']; ?><br>
                        Status:
                        <?php echo $o['orderStatus']; ?>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No orders yet</p>";
            }
            ?>
        </div>

    </div>
</main>
<?php include '../includes/footer.php'; ?>