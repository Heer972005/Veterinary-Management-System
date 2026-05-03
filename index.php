<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PetCare System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body.dark {
    background: #121212;
    color: #fff;
}
.card { border-radius: 12px; }
.section { padding: 60px 0; }
.hero-section {
    background: linear-gradient(135deg, #f5f7ff, #e6ecff);
}

.hero-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.hero-small-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}
.hero-image-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.hero-img {
    width: 100%;
    height: 400px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    object-fit: cover;
}
.unique-box {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.unique-box ul {
    padding-left: 20px;
    list-style: none; 
}
.unique-box ul li {
    position: relative;
    padding-left: 28px;
    margin-bottom: 10px;
}

.unique-box ul li::before {
    content: "🐾";
    position: absolute;
    left: 0;
    top: 0;
}
.product-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    height: 260px;                 /* SAME HEIGHT */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.carousel-img {
    width: 100%;
    height: 180px;
    object-fit: contain;   /* ✅ keeps full image */
    background: #f8f9fa;
}
.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    background-color: rgba(0,0,0,0.6);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

.carousel-control-prev {
    left: 10px;
}

.carousel-control-next {
    right: 10px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1); /* makes arrow white */
}
.service-card {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    cursor: pointer;
}

.service-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: 0.4s;
}

.service-card .overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 15px;
    color: white;
    font-weight: bold;
    text-align: center;

    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
}

.service-card:hover img {
    transform: scale(1.1);
}
.team-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.team-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 10px;
}

.team-card:hover {
    transform: translateY(-5px);
}
.review-slider {
    overflow: hidden;
    position: relative;
}

.review-track {
    display: flex;
    gap: 20px;
    animation: scrollReviews 20s linear infinite;
}

.review-card {
    min-width: 300px;
    background: white;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.review-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
}

.stars {
    color: gold;
}

.review-text {
    font-size: 14px;
}

/* animation */
@keyframes scrollReviews {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>
</head>

<body>
<?php include 'config/db.php'; ?>
<!-- 🔥 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">🐾 PetCare</a>

    <div class="ms-auto">
        <a href="user/shop.php" class="btn btn-outline-light btn-sm">Shop</a>
        <a href="user/appointments.php" class="btn btn-outline-light btn-sm">Appointments</a>
        <button onclick="toggleTheme()" class="btn btn-warning btn-sm">🌙</button>
    </div>
</nav>

<!-- 🔥 HERO CAROUSEL -->
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
        <h5>✨ Why Choose PetCare?</h5>

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

    <!-- 🔽 PRODUCT CAROUSEL -->
     
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

<!-- 🔥 KNOW YOUR PET -->
<div class="container section">
    <h2 class="text-center">Know Your Pet 🐶</h2>

    <form method="POST" class="mt-4 text-center">
        <input type="text" name="pet" placeholder="Pet Name" class="form-control mb-2" required>
        <input type="text" name="type" placeholder="Dog/Cat" class="form-control mb-2" required>
        <button class="btn btn-primary">Analyze</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pet = $_POST['pet'];
        echo "<div class='alert alert-info mt-3 text-center'>
        😂 $pet is 90% cute, 10% chaos!
        Loves food and attention 🐾
        </div>";
    }
    ?>
</div>

<!-- 🔥 PET IMAGE FUN (PLACEHOLDER) -->
<div class="container section text-center">
    <h2>Fun With Your Pet 📸</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" class="form-control mb-2">
        <button class="btn btn-success">Upload & Generate</button>
    </form>

    <p class="mt-3">Coming soon: AI pet transformations 😎</p>
</div>

<!-- 🔥 MAP -->
<div class="container section">
    <h2 class="text-center">Find Us 📍</h2>

    <iframe 
        src="https://www.google.com/maps?q=rajkot&output=embed" 
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