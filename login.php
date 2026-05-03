<?php
session_start();
include 'config/db.php';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("
       SELECT u.*, r.roleName 
       FROM users u
       JOIN user_roles ur ON u.userID = ur.userID
       JOIN roles r ON ur.roleID = r.roleID
       WHERE u.email = ?
    ");

    $stmt->bind_param("s", $email); // "s" = string
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['userID'] = $user['userID'];
            $_SESSION['role'] = $user['roleName'];
            $_SESSION['name'] = $user['userName'];
            // GET USER ROLE
            $userID = $user['userID'];
            $roleCheck = $conn->query("
                SELECT r.roleName 
                FROM user_roles ur
                JOIN roles r ON ur.roleID = r.roleID
                WHERE ur.userID = $userID
            ")->fetch_assoc();
            
            $role = $roleCheck['roleName'];
            if ($role == 'Doctor') {

            $doc = $conn->query("
                SELECT status 
                FROM doctors 
                WHERE userID = $userID
            ")->fetch_assoc();

            if ($doc['status'] != 'Approved') {
                echo "<script>alert('Your doctor account is pending approval'); window.location='login.php';</script>";
                exit();
            }
}
            // Redirect based on role
            if ($user['roleName'] == 'Admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['roleName'] == 'Doctor') {
                header("Location: doctor/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }

        } else {
            echo "<script>alert('Wrong Password');</script>";
        }

    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h2>Login</h2>

    <form method="POST" id="loginForm">
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <button type="submit" name="login" class="btn btn-success">Login</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>