<?php
    require_once "assets/includes/config.php";
    require_once "assets/includes/db.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Fetch user details
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Database Error: " . mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        die("User not found!");
    }

    // Check account age in months
    $user_created = new DateTime($user['created_at']);
    $current_date = new DateTime();
    $interval = $user_created->diff($current_date);
    $months_old = ($interval->y * 12) + $interval->m;

    // Fetch user order count
    $order_query = "SELECT COUNT(*) AS total_orders FROM orders WHERE user_id = '$user_id'";
    $order_result = mysqli_query($conn, $order_query);
    $order_data = mysqli_fetch_assoc($order_result);
    $total_orders = $order_data['total_orders'] ?? 0;

    // Premium status: Account >= 1 month old OR >= 1 total order
    $is_premium = ($months_old >= 1 || $total_orders >= 1);
?>

<!-- CSS -->
<style>
    /* Profile Layout */
    .main-content {
        min-height: 95vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 50px auto;
    }

    .profile-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,.05);
        padding: 50px 30px;
        text-align: center;
        width: 800px;
        height: auto;
        margin: auto;
    }

    .profile-image {
        width: 170px;
        height: 170px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #000000;
        box-shadow: 0 6px 18px rgba(0,0,0,.08);
    }

    .profile-name {
        margin-top: 25px;
        font-family: "Cinzel", serif;
        font-size: 32px;
        font-weight: 700;
        color: #111;
    }

    .my-profile {
        margin-bottom: 30px;
        font-family: "Cinzel", serif;
        font-size: 30px;
        color: #111;
    }

    .profile-role {
        margin-top: 8px;
        display: inline-block;
        padding: 8px 20px;
        border: 1px solid #000;
        border-radius: 10px 30px;
        color: black;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: .5px;
        font-family: "Cinzel", serif;
    }

    .member-since {
        margin: 10px auto;
        font-size: 16px;
        color: #555;
        font-family: "Poppins", sans-serif;
    }

    .premium-img {
        height: 30px;
        width: auto;
    }

    .member-since strong {
        color: #111;
    }

    .home-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;        
        margin-top: 40px;
        margin-bottom: 0;
        padding: 10px 24px;
        background: #000;
        color: #fff;
        text-decoration: none;
        border: 1px solid #000;
        border-radius: 30px;
        font-size: 15px;
        font-weight: 500;
    }

    .home-btn i {
        font-size: 18px;       
        color: white;
        line-height: 1;
    }

    .home-btn:hover {
        background: #fff;
        color: #000;
    }

    .home-btn:hover i {
        background: #fff;
        color: #000;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .main-content {
            min-height: 90vh;
            padding: 30px 15px;
            align-items: flex-start;
        }

        .profile-card {
            width: 100%;
            max-width: 100%;
            height: auto;
            padding: 35px 20px;
            border-radius: 12px;
        }

        .profile-image {
            width: 130px;
            height: 130px;
            border-width: 4px;
        }

        .profile-name {
            margin-top: 20px;
            font-size: 26px;
        }

        .profile-role {
            margin-top: 8px;
            padding: 7px 16px;
            font-size: 16px;
        }

        .premium-img {
            height: 24px;
        }

        .member-since {
            margin-top: 22px;
            font-size: 15px;
            line-height: 1.6;
        }

        .home-btn {
            max-width: 250px;
            padding: 12px 25px;
            font-size: 14px;
            text-align: center;
            margin-top: 25px;
        }

        .home-btn:hover {
            background: #fff;
            color: #000;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<div class="main-content">
    <div class="profile-card text-center">
        <h1 class="my-profile">My Profile</h1>
        <img src="assets/Images/Logo.png" class="profile-image" alt="Profile">
        <h2 class="profile-name"><?php echo $user['name']; ?></h2>

        <p class="member-since">
            <strong>Email :</strong>
            <?php echo $user['email']; ?>
        </p>

        <p class="member-since">
            <strong>Phone :</strong>
            <?php echo $user['phone']; ?>
        </p>

        <p class="member-since">
            <strong>Member Since :</strong>
            <?php echo date("D M Y", strtotime($user['created_at'])); ?>
        </p>
        
        <?php if ($is_premium): ?>
            <div class="profile-role">
                <img src="assets/Images/Logo.png" class="premium-img" alt="premium-badge"> Premium Customer 
            </div>
        <?php endif; ?>
        
        <div>
            <a href="index.php" class="home-btn"><i class="bi bi-house"></i> Home</a>
            <a href="profile-update.php" class="home-btn"><i class="bi bi-pencil"></i> Update Profile</a>
            <a href="my-orders.php" class="home-btn"><i class="bi bi-bag-check"></i> My Orders</a>
            <a href="logout.php" class="home-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>