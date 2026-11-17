<?php
    require_once "assets/includes/config.php";
    require_once "assets/includes/db.php";

    // Session check
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $error_msg = "";
    $success_flag = false;

    // Fetch user data
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Database Error: " . mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        die("User not found!");
    }

    // Handle profile update
    if (isset($_POST['update_profile'])) {
        $name  = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = $_POST['password'];

        // Hash password if provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $update_query = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', password = '$hashed_password' WHERE id = '$user_id'";
        } else {
            $update_query = "UPDATE users SET name = '$name', email = '$email', phone = '$phone' WHERE id = '$user_id'";
        }

        if (mysqli_query($conn, $update_query)) {
            $success_flag = true;
        } else {
            $error_msg = "Failed to update profile: " . mysqli_error($conn);
        }
    }
?>

<!-- CSS Styles -->
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
        padding: 50px 40px;
        text-align: center;
        width: 800px;
        height: auto;
        margin: auto;
    }

    .my-profile {
        margin-bottom: 30px;
        font-family: "Cinzel", serif;
        font-size: 30px;
        color: #111;
    }

    .profile-image {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        margin-bottom: 30px;
        object-fit: cover;
        border: 4px solid #000000;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-group label {
        display: block;
        font-family: "Poppins", sans-serif;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 15px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-family: "Poppins", sans-serif;
        font-size: 15px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #000;
    }

    .home-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;        
        margin-top: 20px;
        padding: 10px 24px;
        background: #000;
        color: #fff;
        text-decoration: none;
        border: 1px solid #000;
        border-radius: 30px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
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
        color: #000;
    }

    .btn-secondary-custom {
        background: #fff;
        color: #000;
    }

    .btn-secondary-custom i {
        color: #000;
    }

    .btn-secondary-custom:hover {
        background: #000;
        color: #fff;
    }

    .btn-secondary-custom:hover i {
        color: #fff;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-family: "Poppins", sans-serif;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-family: "Poppins", sans-serif;
        font-size: 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    /* Responsive Design */
    @media (max-width:768px) {
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

        .home-btn {
            width: 100%;
            max-width: 250px;
            padding: 12px 25px;
            font-size: 14px;
            margin-top: 15px;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<div class="main-content">
    <div class="profile-card">
        <h1 class="my-profile">Update Profile</h1>
        <img src="assets/Images/Logo.png" class="profile-image" alt="Profile">

        <!-- Success Alert -->
        <?php if ($success_flag): ?>
            <div class="alert-success">
                <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
                Profile updated successfully! Redirecting to profile page...
            </div>
            <script>
                setTimeout(function(){
                    window.location.href = 'profile.php';
                }, 2000);
            </script>
        <?php endif; ?>

        <!-- Error Alert -->
        <?php if (!empty($error_msg)): ?>
            <div class="alert-danger"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label>New Password <small style="font-weight:normal; color:#666;">(Leave blank if you don't want to change)</small></label>
                <input type="password" name="password" class="form-control" placeholder="Enter new password">
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" name="update_profile" class="home-btn">
                    <i class="bi bi-check-circle"></i> Save Changes
                </button>
                <a href="profile.php" class="home-btn btn-secondary-custom">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>