<?php include 'includes/header.php'; ?>
<?php include 'config/db.php'; ?>

<main class="flex-grow-1">

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
    } else {

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

        // If Doctor → insert into doctors table
        if ($role == 2) {

            $specialization = $_POST['specialization'];
            $photoPath = "uploads/doctors/default.png";

            if (!empty($_FILES['photo']['name'])) {
                $photoName = time() . "_" . $_FILES['photo']['name'];
                $tmpName = $_FILES['photo']['tmp_name'];

                $photoPath = "uploads/doctors/" . $photoName;
                move_uploaded_file($tmpName, $photoPath);
            }

            $conn->query("
                INSERT INTO doctors(userID, specialization, photo, status)
                VALUES($userID, '$specialization', '$photoPath', 'Pending')
            ");
        }

        // Redirect messages
        if ($role == 2) {
            echo "<script>
                alert('Doctor registration submitted. Wait for admin approval.');
                window.location='login.php';
            </script>";
        } else {
            echo "<script>
                alert('Registered Successfully');
                window.location='login.php';
            </script>";
        }
    }
}
?>
<div class="container mt-5 d-flex justify-content-center">
    <div class="register-card p-4">
    <h2>Register</h2>

    <form method="POST" enctype="multipart/form-data" id="registerForm">
        <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <select name="role" id="role" class="form-control mb-3">
            <option value="1">Admin</option>
            <option value="2">Doctor</option>
            <option value="3">User</option>
        </select>

        <div id="doctorPhotoDiv" style="display:none;">
            <input type="file" name="photo" class="form-control mb-3">
        </div>

        <div id="specializationDiv" style="display:none;">
            <select name="specialization" class="form-control mb-3">
                <option>General</option>
                <option>Skin</option>
                <option>Vaccination</option>
                <option>Surgery</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" name="register" class="paw-shape mt-3">
                <span class="inner-pad"></span>
                <span class="btn-text">Register</span>
            </button>
        </div>
    </form>
</div>
</div>
</main>

<script>
document.getElementById("role").addEventListener("change", function () {
    let role = this.value;

    document.getElementById("doctorPhotoDiv").style.display = (role == 2) ? "block" : "none";
    document.getElementById("specializationDiv").style.display = (role == 2) ? "block" : "none";
});
</script>

<?php include 'includes/footer.php'; ?>