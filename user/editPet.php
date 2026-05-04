<?php
include '../includes/auth.php';
include '../config/db.php';
include '../includes/header.php';

$petID = $_GET['id'];
$userID = $_SESSION['userID'];

// GET EXISTING DATA
$pet = $conn->query("
    SELECT * FROM pets 
    WHERE petID = $petID AND userID = $userID
")->fetch_assoc();

// UPDATE LOGIC
if (isset($_POST['updatePet'])) {

    $petName = $_POST['petName'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $conn->query("
        UPDATE pets 
        SET petName='$petName',
            species='$species',
            breed='$breed',
            dateOfBirth='$dob',
            gender='$gender'
        WHERE petID = $petID AND userID = $userID
    ");

    echo "<script>alert('Pet Updated'); window.location='pets.php';</script>";
}
?>

<div class="container mt-5">
    <h2>Edit Pet</h2>

    <form method="POST">
        <input type="text" name="petName" class="form-control mb-2" value="<?php echo $pet['petName']; ?>" required>

        <input type="text" name="species" class="form-control mb-2" value="<?php echo $pet['species']; ?>" required>

        <input type="text" name="breed" class="form-control mb-2" value="<?php echo $pet['breed']; ?>">

        <input type="date" name="dob" class="form-control mb-2" value="<?php echo $pet['dateOfBirth']; ?>" required>

        <select name="gender" class="form-control mb-2">
            <option <?php if ($pet['gender'] == 'Male')
                echo 'selected'; ?>>Male</option>
            <option <?php if ($pet['gender'] == 'Female')
                echo 'selected'; ?>>Female</option>
        </select>

        <button type="submit" name="updatePet" class="btn btn-success">
            Update Pet
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>