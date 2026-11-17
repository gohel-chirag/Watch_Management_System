<?php
    require_once("auth.php");
    include("../assets/includes/db.php");

    // 1. Total Users Count
    $user_query = "SELECT COUNT(*) as total_users FROM users";
    $user_result = mysqli_query($conn, $user_query);
    $total_users = mysqli_fetch_assoc($user_result)['total_users'];

    // 2. Total Watches Count
    $watch_query = "SELECT COUNT(*) as total_watches FROM watches";
    $watch_result = mysqli_query($conn, $watch_query);
    $total_watches = mysqli_fetch_assoc($watch_result)['total_watches'];

    // 3. Total Orders Count
    $order_query = "SELECT COUNT(*) as total_orders FROM orders";
    $order_result = mysqli_query($conn, $order_query);
    $total_orders = mysqli_fetch_assoc($order_result)['total_orders'];

    // 4. Total Revenue
    $revenue_query = "SELECT SUM(amount) as total_revenue FROM orders";
    $revenue_result = mysqli_query($conn, $revenue_query);
    $revenue_row = mysqli_fetch_assoc($revenue_result);
    $total_revenue = $revenue_row['total_revenue'] ? $revenue_row['total_revenue'] : 0;

    // 5. Recent Orders Query (Latest 5 orders)
    $recent_orders_query = "SELECT * FROM orders ORDER BY created_at DESC LIMIT 5";
    $recent_orders_result = mysqli_query($conn, $recent_orders_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Rolex - Dashboard</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>

    <!-- Font-Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&amp;family=Poppins:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/Images/favicon.png">

    <!-- CSS -->
    <style>
        /*================ Dashboard =================*/
        /* Body */
        html {
            overflow-y: scroll;
        }   
        body{
            background:#f8f9fa;
            font-family:Arial,sans-serif;
        }

        /* Sidebar */
        .sidebar{
            position:fixed;
            top:0;
            left:0;
            width:240px;
            height:100vh;
            background:#fff;
            border-right:1px solid #e5e5e5;
            padding:20px;
            box-shadow:4px 0 12px rgba(0,0,0,.05);
        }

        .sidebar img{
            width:120px;
            display:block;
            margin:30px auto;
        }

        .sidebar a{
            display:block;
            color:#333;
            text-decoration:none;
            padding:12px 30px;
            border:1px solid #000;
            border-radius:30px;
            margin-bottom:8px;
            font-size:15px;
            transition:.3s;
        }

        .sidebar a i{
            margin-right:10px;
        }

        .sidebar a:hover,
        .sidebar a.active{
            background:#000;
            color:#fff;
        }

        /* Main Content */
        .main-content{
            margin-left:260px;
            padding:30px;
        }

        /* Top Navbar */
        .top-navbar{
            background: #fff;
            padding: 18px 25px;
            border-radius: 14px;
            border: 1px solid #e5e5e5;
            box-shadow: 0 4px 12px rgba(0,0,0,.05);
            margin-bottom: 30px;
        }

        .top-navbar h3{
            margin: 0;
            color: #111;
            font-family: "Cinzel", serif;
            font-weight: 700;
        }

        .admin-info{
            text-align: right;
        }

        .admin-info h5{
            margin: 0 0 8px;
            color: #111;
            font-family: "Cinzel", serif;
            font-weight: 600;
            font-size: 20px;
        }

        .admin-info p{
            margin: 0;
            font-size: 14px;
            color: #666;
            line-height: 1.7;
            font-family: "Poppins", sans-serif;
        }

        .admin-info p strong{
            color: #222;
            font-weight: 600;
        }

        /* Dashboard Cards */
        .dashboard-card{
            background:#fff;
            border:1px solid #e5e5e5;
            border-radius:14px;
            padding:25px;
            text-align:center;
            box-shadow:0 4px 12px rgba(0,0,0,.05);
            transition:.3s;
        }

        .dashboard-card:hover{
            transform:translateY(-5px);
            border-color:#000;
            box-shadow:0 10px 20px rgba(0,0,0,.10);
        }

        .dashboard-card h5{
            color:#666;
            margin-bottom:10px;
            font-family: "Cinzel", serif;
        }

        .dashboard-card h3{
            font-size:30px;
            font-weight:bold;
            color:#000;
        }

        /* Table Box */
        .table-box{
            background:#fff;
            margin-top:30px;
            padding:25px;
            border:1px solid #e5e5e5;
            border-radius:14px;
            box-shadow:0 4px 12px rgba(0,0,0,.05);
        }

        .table-box h4, th{
            font-family: "Cinzel", serif;
        }

        .table{
            margin-bottom:0;
        }

        .table th,
        .table td{
            vertical-align:middle;
        }

        /* Premium Status Badges */
        .badge{
            padding:8px 14px;
            border-radius:20px;
            font-size:13px;
            font-weight:500;
            letter-spacing:.3px;
            border:1px solid transparent;
        }

        /* Completed / Delivered */
        .bg-success{
            background:#eaf8ee !important;
            color:#198754 !important;
            border-color:#b9e7c8 !important;
        }

        /* Pending */
        .bg-warning{
            background:#fff8e5 !important;
            color:#b8860b !important;
            border-color:#ffe08a !important;
        }

        /* Shipped / Processing */
        .bg-primary{
            background:#eef4ff !important;
            color:#0d6efd !important;
            border-color:#bcd4ff !important;
        }

        /* Cancelled */
        .bg-danger{
            background:#fdecec !important;
            color:#dc3545 !important;
            border-color:#f5b8bf !important;
        }

        /* Mobile */
        @media(max-width:768px){
            .sidebar{
                width:100%;
                height:auto;
                position:relative;
                padding:15px;
            }

            .sidebar img{
                width:100px;
            }

            .main-content{
                margin-left:0;
                padding:20px;
            }

            .dashboard-card{
                padding:20px;
            }

            .top-navbar{
                flex-direction: column;
                align-items: flex-start !important;
                gap: 15px;
            }

            .admin-info{
                width: 100%;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="../assets/Images/Logo.png" alt="Logo"/>
        <a href="dashboard.php" class="active">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="add-watch.php"> <i class="bi bi-plus-circle"></i> Add Watch </a>
        <a href="manage-watch.php"> <i class="bi bi-watch"></i> Manage Watch </a>
        <a href="orders.php"> <i class="bi bi-cart"></i> Orders </a>
        <a href="users.php"> <i class="bi bi-people"></i> Users </a>
        <a href="reports.php"> <i class="bi bi-bar-chart"></i> Reports </a>
        <a href="../logout.php"> <i class="bi bi-box-arrow-right"></i> Logout </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h3>Dashboard</h3>

            <div class="admin-info text-end">
                <h5 class="mb-1">Welcome <?php echo $_SESSION['name']; ?></h5>

                <p class="mb-0">
                    <strong>Admin ID :</strong>
                    <?php echo $_SESSION['admin_id']; ?>
                </p>

                <p class="mb-0">
                    <strong>Name :</strong>
                    <?php echo $_SESSION['name']; ?>
                </p>

                <p class="mb-0">
                    <strong>Email :</strong>
                    <?php echo $_SESSION['email']; ?>
                </p>
            </div>
        </div>

        <!-- Cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h5>Total Users</h5>
                    <h3><?php echo number_format($total_users); ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card">
                    <h5>Total Watches</h5>
                    <h3><?php echo number_format($total_watches); ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card">
                    <h5>Total Orders</h5>
                    <h3><?php echo number_format($total_orders); ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card">
                    <h5>Revenue</h5>
                    <h3>₹<?php echo number_format($total_revenue, 2); ?></h3>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="table-box text-center">
            <h4 class="mb-3">Recent Orders</h4>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (mysqli_num_rows($recent_orders_result) > 0) { 
                        while ($order = mysqli_fetch_assoc($recent_orders_result)) {
                            // Set badge class based on status
                            $status = $order['order_status'];
                            $badge_class = "bg-primary";
                            if (strtolower($status) == 'completed' || strtolower($status) == 'delivered') {
                                $badge_class = "bg-success";
                            } elseif (strtolower($status) == 'pending') {
                                $badge_class = "bg-warning text-dark";
                            } elseif (strtolower($status) == 'cancelled') {
                                $badge_class = "bg-danger";
                            }
                    ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td>₹<?php echo number_format($order['amount'], 2); ?></td>
                            <td><span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($status); ?></span></td>
                        </tr>
                    <?php 
                        } 
                    } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">No recent orders found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>