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
.hero-img { height: 400px; object-fit: cover; }
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
    max-width: 300px;
    height: auto;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

</style>
</head>

<body>

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
                        Smart Care for Your Pets 🐾
                    </h1>

                    <p class="mt-3">
                        From health checkups to shopping, everything your pet needs in one place.
                    </p>

                    <a href="user/appointments.php" class="btn btn-primary mt-3">
                        Book Appointment
                    </a>
                    <div class="hero-image-wrapper mt-4">
                        <img src="assets/homePet.png" class="hero-img">
                    </div>
                </div>
            </div>

            <!-- RIGHT CARDS -->
            <div class="col-md-6">
                <div class="row g-3">

                    <div class="col-12">
                        <div class="hero-small-card p-3">
                            <h5>🐶 Pet Health Insights</h5>
                            <p>Track your pet's health & history easily.</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="hero-small-card p-3">
                            <h5>🛒 Smart Pet Shopping</h5>
                            <p>Buy medicines & accessories instantly.</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- 🔥 SERVICES -->
<div class="container section">
    <h2 class="text-center mb-4">Our Services</h2>
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card p-3">💊 Medical Care</div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">🛒 Pet Shop</div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">📅 Appointments</div>
        </div>
    </div>
</div>

<!-- 🔥 TEAM -->
<div class="container section">
    <h2 class="text-center">Meet Our Team</h2>
    <div class="row text-center mt-4">
        <div class="col-md-4">
            <div class="card p-3">
                👨‍⚕️ Dr. Smith<br>Veterinarian
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                👩‍⚕️ Dr. Jane<br>Surgeon
            </div>
        </div>
    </div>
</div>

<!-- 🔥 TESTIMONIALS -->
<div class="container section">
    <h2 class="text-center">Why Pet Owners Trust Us</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            ⭐⭐⭐⭐⭐ “Amazing service!”
        </div>
        <div class="col-md-6">
            ⭐⭐⭐⭐⭐ “My dog loves it here!”
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
<script>
window.onload = function () {
    document.querySelector(".loader").style.display = "none";
};
</script>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>