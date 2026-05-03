<?php include 'includes/header.php'; ?>
<?php include 'config/db.php'; ?>
<link rel="stylesheet" href="assets/css/index.css">
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

    $specialization = $_POST['specialization'];

    // Default image
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

    // echo "<script>alert('Registered Successfully'); window.location='login.php';</script>";
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
?>
<div class="container mt-5">
    <h2>Register</h2>
    <form method="POST" enctype="multipart/form-data" id="registerForm">
        <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <select name="role" id="role"class="form-control mb-3">
            <option value="1">Admin</option>
            <option value="2">Doctor</option>
            <option value="3">User</option>
        </select>

        <!-- 🔥 DOCTOR PHOTO (HIDDEN INITIALLY) -->
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

        <button type="submit" name="register" class="buttonColor">Register</button>
    </form>
</div>
<script>
document.getElementById("role").addEventListener("change", function () {
    let role = this.value;

    if (role == 2) { // Doctor
        document.getElementById("doctorPhotoDiv").style.display = "block";
        document.getElementById("specializationDiv").style.display = "block";
    } else {
        document.getElementById("doctorPhotoDiv").style.display = "none";
        document.getElementById("specializationDiv").style.display = "none";
    }
});
</script>
<?php include 'includes/footer.php'; ?>