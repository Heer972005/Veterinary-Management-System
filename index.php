<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PetCare System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
<?php include 'config/db.php'; ?>
<!--  NAVBAR -->
<nav class="navbar navbar-expand-lg custom-navbar px-3">
    
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="assets/images/logo1.png" class="logo-img">
    </a>

    <!-- Right side buttons -->
    <div class="ms-auto">
        <a href="register.php" class="btn btn-dark btn-sm me-2">REGISTER</a>
        <a href="login.php" class="btn btn-dark btn-sm me-2">LOGIN</a>
        <a href="user/shop.php" class="btn btn-dark btn-sm me-2">SHOP</a>
        <button onclick="toggleTheme()" class="btn btn-warning btn-sm">🌙</button>
    </div>

</nav>

<!--  HERO CAROUSEL -->
<div class="hero-section py-5">
    <div class="container">
        <div class="row g-4">

            <!-- LEFT MAIN CARD -->
            <div class="col-md-6">
                <div class="hero-card p-4 h-100">
                    <h1 class="fw-bold">
                        Smart Care for Your Pets
                    </h1>

                    <p class="mt-3">
                        From health checkups to shopping, everything your pet needs in one place.
                    </p>

                    <a href="user/appointments.php" class="btn btn-primary mt-3">
                        Book Appointment
                    </a>
                    <div class="hero-image-wrapper mt-4">
                        <img src="assets/images/homePet.jpg" class="hero-img">
                    </div>
                </div>
            </div>

     <div class="col-md-6">

    <!-- 🔝 UNIQUE SECTION -->
    <div class="unique-box p-4 mb-4">
        <h5> Why Choose PetCare?</h5>

        <ul class="mt-3">
            <li>Experienced & trusted doctors</li>
            <li>Smart digital pet tracking</li>
            <li>Instant medicine ordering</li>
            <li>Easy online appointment booking</li>
            <li>Online consultancy</li>
            <li>24/7 pet care support</li>
            <li>Affordable pricing</li>
            <li>Convenient online services</li>
            <li>Happy pets, happy owners!</li>
        </ul>
    </div>

    <!--  PRODUCT CAROUSEL -->
    <div class="container section">
    <h2 class="text-center mb-4">Popular Pet Products 🛒</h2>

    <div class="product-slider">
        <div class="product-track">

            <?php
            $products = [
                ["pro1.jpg", "Premium Dog Food"],
                ["pro2.jpg", "Chew Toys"],
                ["pro3.jpg", "Cozy Homes"],
                ["pro4.jpg", "Clothes"],
                ["pro5.jpg", "Grooming Products"]
            ];

            // duplicate for infinite scroll
            foreach (array_merge($products, $products) as $p) {
                echo "
                <div class='product-card'>
                    <img src='assets/images/petProducts/{$p[0]}' class='product-img'>
                    <p class='mt-2'>{$p[1]}</p>
                </div>
                ";
            }
            ?>

        </div>
    </div>
</div>
        </div>
    </div>
</div>
<!-- 🔥 SERVICES -->
 <div class="container section">
    <h2 class="text-center mb-4">Our Services</h2>

    <div class="row g-4">

        <!-- CARD 1 -->
        <div class="col-md-4">
            <div class="service-card">
                <img src="assets/images/services/medicalCare.jpg">
                <div class="overlay">Medical Care</div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="col-md-4">
            <div class="service-card">
                <img src="assets/images/services/pet_shop.jpg">
                <div class="overlay">Pet Shop</div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="col-md-4">
            <div class="service-card">
                <img src="assets/images/services/pet_appointment.jpg">
                <div class="overlay">Appointments</div>
            </div>
        </div>

    </div>
</div>

<!-- 🔥 TEAM -->
<div class="container section">
    <h2 class="text-center">Meet Our Team 👨‍⚕️</h2>

    <div class="row mt-4">

        <?php
        $docs = $conn->query("
            SELECT d.*, u.userName 
            FROM doctors d
            JOIN users u ON d.userID = u.userID
        ");

        while ($d = $docs->fetch_assoc()) {
        ?>

        <div class="col-md-4">
            <div class="team-card">
                <?php
                    $img = (!empty($d['photo']) && file_exists($d['photo'])) 
                    ? $d['photo'] : "assets/images/doctor.jpg";
                ?>
                <img src="<?php echo $img; ?>" class="team-img">
                <h5><?php echo $d['userName']; ?></h5>
                <p><?php echo $d['specialization']; ?></p>
            </div>
        </div>

        <?php } ?>

    </div>
</div>

<!-- 🔥 TESTIMONIALS -->
<div class="container section">
    <h2 class="text-center mb-4">Why Pet Owners Trust Us ❤️</h2>

    <div class="review-slider">
        <div class="review-track">

            <?php
            $reviews = [
                ["review1.jpg", "Riya Sharma", "Amazing service! My pet feels so comfortable here."],
                ["review2.jpg", "Aman Patel", "Doctors are very caring. Highly recommended!"],
                ["review3.jpg", "Neha Joshi", "My dog loves it here! Best clinic experience."],
                ["review4.jpg", "Rahul Mehta", "Very professional and friendly doctors."]
            ];

            // duplicate for infinite effect
            foreach (array_merge($reviews, $reviews) as $r) {
                echo "
                <div class='review-card'>
                    <img src='assets/images/reviews/{$r[0]}' class='review-img'>
                    <h5>{$r[1]}</h5>
                    <p class='stars'>⭐⭐⭐⭐⭐</p>
                    <p class='review-text'>{$r[2]}</p>
                </div>
                ";
            }
            ?>
        </div>
    </div>
</div>
<div class="container section">
    <div class="row g-4 align-items-center">

        <!-- LEFT SIDE (IMAGE + HEADING) -->
        <div class="col-md-6">
            <div class="highlight-box p-4">
                <h2 class="fw-bold">
                    Caring for Pets with Love 🐾
                </h2>

                <p class="mt-3">
                    Your trusted partner for pet healthcare, grooming, and happiness.
                </p>

                <img src="assets/images/homePet.jpg" class="highlight-img mt-3">
            </div>
        </div>

        <!-- RIGHT SIDE (STATS + TEXT) -->
        <div class="col-md-6">

            <div class="stat-card mb-3">
                🐶 500+ Happy Pets Treated
            </div>

            <div class="stat-card mb-3">
                👨‍⚕️ Certified & Verified Doctors
            </div>

            <div class="stat-card mb-3">
                ⏱️ Fast & Easy Online Booking
            </div>

            <div class="info-box mt-3">
                PetCare is designed to simplify pet healthcare. From booking appointments
                to buying products, everything is available in one place — making life
                easier for pet owners and safer for pets.
            </div>

        </div>

    </div>
</div>
<!-- 🔥 KNOW YOUR PET -->
<!-- <div class="container section">
    <h2 class="text-center">Know Your Pet 🐶</h2>

    <form method="POST" class="mt-4 text-center">
        <input type="text" name="pet" placeholder="Pet Name" class="form-control mb-2" required>
        <input type="text" name="type" placeholder="Dog/Cat" class="form-control mb-2" required>
        <button class="btn btn-primary">Analyze</button>
    </form>

    //<?php
    //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //    $pet = $_POST['pet'];
    //    echo "<div class='alert alert-info mt-3 text-center'>
    //    😂 $pet is 90% cute, 10% chaos!
    //    Loves food and attention 🐾
    //    </div>";
    //}
    //?>
</div> -->

<!-- 🔥 PET IMAGE FUN (PLACEHOLDER) -->
<!-- <div class="container section text-center">
    <h2>Fun With Your Pet 📸</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" class="form-control mb-2">
        <button class="btn btn-success">Upload & Generate</button>
    </form>

    <p class="mt-3">Coming soon: AI pet transformations 😎</p>
</div> -->

<!-- 🔥 MAP -->
<div class="container section">
    <h2 class="text-center">Find Us 📍</h2>

    <iframe 
        src="https://www.google.com/maps?q=marwadi+university&output=embed" 
        width="100%" height="300">
    </iframe>
</div>

<!-- 🔥 FOOTER -->
<footer class="bg-dark text-white text-center p-4">
    <p>© 2026 PetCare System</p>
    <p>
        Instagram | LinkedIn | Website
    </p>
</footer>

<!-- 🔥 JS -->
<script>
function toggleTheme() {
    document.body.classList.toggle("dark");
}
window.onload = function () {
    document.querySelector(".loader").style.display = "none";
};

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>