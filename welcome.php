<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Luxury Rolex Portal</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/Images/favicon.png">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111;
            padding: 20px 0;
        }

        .starter-container {
            max-width: 900px;
            width: 90%;
            background: #ffffff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid #c9a227;
            text-align: center;
        }

        /* Branding Section */
        .brand-logo img {
            width: 100px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .section-title h2 {
            font-family: 'Cinzel', serif;
            font-size: 32px;
            font-weight: 700;
            color: #111111;
            letter-spacing: 1px;
        }

        .title-divider {
            width: 80px;
            height: 3px;
            background: #c9a227;
            margin: 12px auto 20px auto;
        }

        .subtitle {
            color: #666666;
            font-size: 15px;
            margin-bottom: 35px;
        }

        /* Access Cards */
        .portal-card {
            background: #ffffff;
            border: 1px solid #c9a227;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            transition: border-color 0.2s ease;
        }

        .icon-box {
            width: 65px;
            height: 65px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: 1px solid #e8e8e8;
        }

        .icon-box i {
            font-size: 28px;
            color: #000000;
        }

        .portal-card h4 {
            font-family: 'Cinzel', serif;
            font-size: 20px;
            font-weight: 700;
            color: #111111;
            margin-bottom: 10px;
        }

        .portal-card p {
            color: #666666;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        /* Minimal Buttons */
        .btn-outline-gold {
            border: 1px solid #000000 !important;
            color: #000000 !important;
            background: #ffffff !important;
            border-radius: 30px;
            padding: 10px 24px;
            font-weight: 500;
            transition: background 0.2s ease, color 0.2s ease;
            text-decoration: none;
            display: inline-block;
            width: 100%;
        }

        .btn-outline-gold:hover {
            background: #000000 !important;
            color: #ffffff !important;
        }

        /* Gold highlight button variant */
        .btn-gold-accent {
            border: 1px solid #c9a227 !important;
            color: #000000 !important;
            background: #ffffff !important;
        }

        .btn-gold-accent:hover {
            background: #c9a227 !important;
            color: #ffffff !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .starter-container {
                padding: 30px 20px;
            }

            .section-title h2 {
                font-size: 24px;
            }

            .portal-card {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>

    <div class="starter-container">
        <!-- Logo / Icon -->
        <div class="brand-logo">
            <img src="assets\Images\Logo.png" alt="Rolex Logo">
        </div>

        <!-- Section Title -->
        <div class="section-title">
            <h2>Rolex Collections</h2>
            <div class="title-divider"></div>
        </div>
        <p class="subtitle">Please select a portal to continue</p>

        <!-- Access Portals Grid -->
        <div class="row g-4">
            <!-- User Website Option -->
            <div class="col-md-6">
                <div class="portal-card">
                    <div class="icon-box">
                        <i class="fa-solid fa-gem"></i>
                    </div>
                    <div>
                        <h4>E-STORE / WEBSITE</h4>
                        <p>Explore the latest luxury watch collections, new arrivals, and official products.</p>
                    </div>
                    <a href="index.php" class="btn-outline-gold">
                        Go to Website <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <!-- Admin Portal Option -->
            <div class="col-md-6">
                <div class="portal-card">
                    <div class="icon-box">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <h4>ADMIN PORTAL</h4>
                        <p>Access the control panel for order management, product updates, and manage users.</p>
                    </div>
                    <a href="admin/dashboard.php" class="btn-outline-gold">
                        Admin Login <i class="fa-solid fa-lock ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>