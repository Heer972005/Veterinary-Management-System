<?php include 'includes/header.php'; ?>
<?php include 'config/db.php'; ?>

<?php
if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check duplicate email
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists');</script>";
        return;
    }

    // Insert user
    $conn->query("
        INSERT INTO users(userName, email, password) 
        VALUES('$name','$email','$password')
    ");

    $userID = $conn->insert_id;

    // Assign role
    $conn->query("
        INSERT INTO user_roles(userID, roleID) 
        VALUES($userID, $role)
    ");

    // 🔥 IMPORTANT: If Doctor → insert into doctors table
    if ($role == 2) {
        $conn->query("
            INSERT INTO doctors(userID, specialization) 
            VALUES($userID, 'General')
        ");
    }

    echo "<script>alert('Registered Successfully'); window.location='login.php';</script>";
}
?>
<div class="container mt-5">
    <h2>Register</h2>

    <form method="POST" id="registerForm">
        <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <select name="role" class="form-control mb-3">
            <option value="1">Admin</option>
            <option value="2">Doctor</option>
            <option value="3">User</option>
        </select>

        <button type="submit" name="register" class="btn btn-primary">Register</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>