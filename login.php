<?php
session_start();
include 'config/db.php';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // ✅ Prepared statement
    $stmt = $conn->prepare("
        SELECT u.*, r.roleName 
        FROM users u
        JOIN user_roles ur ON u.userID = ur.userID
        JOIN roles r ON ur.roleID = r.roleID
        WHERE u.email = ?
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        // ✅ Password check
        if (password_verify($password, $user['password'])) {

            $_SESSION['userID'] = $user['userID'];
            $_SESSION['role'] = $user['roleName'];
            $_SESSION['name'] = $user['userName'];

            $userID = (int)$user['userID'];

            // ================= DOCTOR APPROVAL =================
            if ($user['roleName'] == 'Doctor') {

                $doc = $conn->query("
                    SELECT status 
                    FROM doctors 
                    WHERE userID = $userID
                ");

                if ($doc->num_rows > 0) {
                    $docData = $doc->fetch_assoc();

                    if ($docData['status'] != 'Approved') {
                        echo "<script>
                            alert('Your doctor account is pending approval');
                            window.location='login.php';
                        </script>";
                        exit();
                    }
                } else {
                    echo "<script>
                        alert('Doctor record not found');
                        window.location='login.php';
                    </script>";
                    exit();
                }
            }

            // ================= REDIRECT BACK =================
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header("Location: $redirect");
                exit();
            }

            // ================= DEFAULT REDIRECT =================
            if ($user['roleName'] == 'Admin') {
                header("Location: admin/dashboard.php");
                exit();
            } elseif ($user['roleName'] == 'Doctor') {
                header("Location: doctor/dashboard.php");
                exit();
            } else {
                header("Location: user/dashboard.php");
                exit();
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

<main class="flex-grow-1 d-flex align-items-center justify-content-center">

    <div class="paw-login-wrapper">
        <div class="paw-login">

            <h2 class="text-center mb-4">Login</h2>

            <form method="POST" id="loginForm">
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

                <button type="submit" name="login" class="btn btn-success w-100">
                    Login
                </button>
            </form>

        </div>
    </div>

</main>

<?php include 'includes/footer.php'; ?>