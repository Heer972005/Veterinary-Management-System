<?php 
include '../includes/auth.php'; 
include '../config/db.php';
include '../includes/header.php'; 
?>
<?php
if (isset($_POST['addPet'])) {

    $petName = $_POST['petName'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $userID = $_SESSION['userID'];

    $sql = "INSERT INTO pets(userID, petName, species, breed, age, gender)
            VALUES($userID, '$petName', '$species', '$breed', '$age', '$gender')";

    $conn->query($sql);

    echo "<script>alert('Pet Added'); window.location='pets.php';</script>";
}
?>


<div class="container mt-5">
    <h2>My Pets 🐾</h2>

    <!-- ADD PET FORM -->
    <form method="POST" class="mb-4">
        <input type="text" name="petName" class="form-control mb-2" placeholder="Pet Name" required>
        
        <input type="text" name="species" class="form-control mb-2" placeholder="Species (Dog, Cat)" required>
        
        <input type="text" name="breed" class="form-control mb-2" placeholder="Breed">
        
        <input type="number" name="age" class="form-control mb-2" placeholder="Age">
        
        <select name="gender" class="form-control mb-2">
            <option>Male</option>
            <option>Female</option>
        </select>

        <button type="submit" name="addPet" class="btn btn-primary">Add Pet</button>
    </form>

    <!-- DISPLAY PETS -->
    <div class="row">
        <?php
        $userID = $_SESSION['userID'];

        $result = $conn->query("SELECT * FROM pets WHERE userID = $userID");

        while ($row = $result->fetch_assoc()) {
        ?>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5><?php echo $row['petName']; ?></h5>
                    <p>Species: <?php echo $row['species']; ?></p>
                    <p>Breed: <?php echo $row['breed']; ?></p>
                    <p>Age: <?php echo $row['age']; ?></p>
                    <p>Gender: <?php echo $row['gender']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>