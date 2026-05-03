<?php 
include '../includes/auth.php';
include '../config/db.php';
include '../includes/header.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer-master/PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';
// ADMIN CHECK
$userID = $_SESSION['userID'];

$roleCheck = $conn->query("
    SELECT r.roleName 
    FROM user_roles ur
    JOIN roles r ON ur.roleID = r.roleID
    WHERE ur.userID = $userID
")->fetch_assoc();

if ($roleCheck['roleName'] != 'Admin') {
    die("Access Denied");
}

// APPROVE LOGIC
if (isset($_GET['approve'])) {

    $id = (int)$_GET['approve']; // secure

    // UPDATE STATUS
    $conn->query("
        UPDATE doctors 
        SET status = 'Approved' 
        WHERE doctorID = $id
    ");

    // GET USER DETAILS
    $user = $conn->query("
        SELECT u.email, u.userName 
        FROM users u
        JOIN doctors d ON u.userID = d.userID
        WHERE d.doctorID = $id
    ")->fetch_assoc();

    // EMAIL SETUP

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'heermehta.126700@marwadiuniversity.ac.in'; // change
        $mail->Password = 'xwie orxh wdcz obav';    // change
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('heermehta.126700@marwadiuniversity.ac.in', 'PetCare Clinic');

        $mail->addAddress($user['email'], $user['userName']);
        $mail->isHTML(true);
        $mail->Subject = "Doctor Approved";

        $mail->Body = "
            <h2>Congratulations Dr. {$user['userName']} </h2>
            <p>Your doctor account has been <b>approved</b>.</p>
            <p>You can now login and start managing appointments.</p>
            <br>
            <p>– PetCare Team 🐾</p>
        ";

        $mail->send();

    } catch (Exception $e) {
        // optional: log error
    }

    // REDIRECT AFTER EVERYTHING
    echo "<script>alert('Doctor Approved & Email Sent'); window.location='approveDocs.php';</script>";
}

// FETCH PENDING DOCTORS
$docs = $conn->query("
    SELECT d.*, u.userName 
    FROM doctors d
    JOIN users u ON d.userID = u.userID
    WHERE d.status = 'Pending'
");
?>

<div class="container mt-5">
    <h2>Approve Doctors </h2>

    <?php if ($docs->num_rows > 0): ?>
        <?php while ($d = $docs->fetch_assoc()): ?>

            <?php
                $img = $d['photo'] ? "../".$d['photo'] : "../assets/default-doctor.png";
            ?>

            <div class="card p-3 mb-3 shadow">
                <b><?php echo $d['userName']; ?></b><br>
                Specialization: <?php echo $d['specialization']; ?><br><br>

                <img src="<?php echo $img; ?>" width="100" style="border-radius:10px;"><br>

                <a href="?approve=<?php echo $d['doctorID']; ?>" 
                   class="btn btn-success mt-2">
                   Approve
                </a>
            </div>

        <?php endwhile; ?>
    <?php else: ?>
        <p>No pending doctors</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>