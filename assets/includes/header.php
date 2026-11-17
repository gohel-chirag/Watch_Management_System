<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Rolex - Luxury Watches</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Font-Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&amp;family=Poppins:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets\css\style.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/Images/favicon.png">
</head>
<body>

<!-- Header -->
<header>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img alt="Logo" class="logo img-fluid" src="assets\Images\Logo.png">
            </a>
            <button class="navbar-toggler" data-bs-target="#navbar" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <?php
                    $currentPage = basename($_SERVER['PHP_SELF']);
                ?>

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'products.php') ? 'active' : ''; ?>" href="products.php">PRODUCTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'about.php') ? 'active' : ''; ?>" href="about.php">ABOUT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>" href="contact.php">CONTACT</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center nav-icons">
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person" style="font-size:25px;"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <!-- User is logged in -->
                                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-circle me-2"></i>My Profile</a></li>
                                <li><a class="dropdown-item" href="my-orders.php"><i class="bi bi-bag-check me-2"></i>My Orders</a></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            <?php else: ?>
                                <!-- User is not logged in -->
                                <li><a class="dropdown-item" href="login.php"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                                <li><a class="dropdown-item" href="register.php"><i class="bi bi-person-plus me-2"></i>Register</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <a href="cart.php"><i class="bi bi-cart3 fs-4" style="font-size:20px;"></i></a>
                </div>
            </div>
        </div>
    </nav>
</header>