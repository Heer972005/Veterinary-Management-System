<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body class="d-flex flex-column min-vh-100">
<div class="loader">
    <video autoplay muted loop playsinline class="loader-video">
        <source src="../assets/loader.mp4" type="video/mp4">
    </video>
    <h2>Loading...</h2>
</div>
<nav class="navbar navbar-expand-lg custom-navbar px-3">
    
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="assets/images/logo1.png" class="logo-img">
    </a>

    <!-- Right side buttons -->
    <div class="ms-auto">
        <a href="register.php" class="btn btn-dark btn-sm me-2 ">REGISTER</a>
        <a href="login.php" class="btn btn-dark btn-sm me-2">LOGIN</a>
        <a href="shop.php" class="btn btn-dark btn-sm me-2">SHOP</a>
        <button onclick="toggleTheme()" class="btn btn-warning btn-sm">🌙</button>
    </div>

</nav>