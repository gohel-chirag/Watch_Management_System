<?php
    require_once("auth.php");
    include("../assets/includes/db.php");

    // Today's Sales Query
    $today_query = "SELECT SUM(amount) as today_sales FROM orders WHERE DATE(created_at) = CURDATE()";
    $today_result = mysqli_query($conn, $today_query);
    $today_sales = mysqli_fetch_assoc($today_result)['today_sales'] ?? 0;

    // Monthly Sales Query
    $monthly_query = "SELECT SUM(amount) as monthly_sales FROM orders WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
    $monthly_result = mysqli_query($conn, $monthly_query);
    $monthly_sales = mysqli_fetch_assoc($monthly_result)['monthly_sales'] ?? 0;

    // Yearly Sales Query
    $yearly_query = "SELECT SUM(amount) as yearly_sales FROM orders WHERE YEAR(created_at) = YEAR(CURDATE())";
    $yearly_result = mysqli_query($conn, $yearly_query);
    $yearly_sales = mysqli_fetch_assoc($yearly_result)['yearly_sales'] ?? 0;

    // Total Revenue Query
    $revenue_query = "SELECT SUM(amount) as total_revenue FROM orders";
    $revenue_result = mysqli_query($conn, $revenue_query);
    $total_revenue = mysqli_fetch_assoc($revenue_result)['total_revenue'] ?? 0;

    // Daily Sales Report Query
    $sales_report_query = "SELECT DATE(created_at) as order_date, COUNT(order_id) as total_orders, SUM(amount) as total_amount 
                          FROM orders 
                          GROUP BY DATE(created_at) 
                          ORDER BY order_date DESC";
    $sales_report_result = mysqli_query($conn, $sales_report_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Rolex - Reports</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/Images/favicon.png">

    <!-- Custom CSS -->
    <style>
        html {
            overflow-y: scroll;
        }
        body{
            background:#f8f9fa;
            font-family:Arial,sans-serif;
        }

        /* Sidebar Styling */
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

        /* Main Content Layout */
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

        /* Summary Cards */
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

        /* Report Table Container */
        .table-box{
            margin-top:35px;
            background-color:white;
            border-radius:30px;
            padding:25px 15px;
        }

        .table-box h4{
            font-size:28px;
            font-weight:700;
            color:#111;
            margin-bottom:25px;
            font-family: "Cinzel", serif;
        }

        .table thead th{
            padding:15px;
            text-align:center;
            font-size:17px;
            font-family: "Cinzel", serif;
        }

        .table tbody td{
            padding:16px;
            font-size:15px;
            font-family:"Poppins", sans-serif;
        }

        .table tbody tr:hover{
            background:#f8f9fa;
        }

        /* Mobile View Styles */
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
                min-height:auto;
                padding:22px;
            }

            .dashboard-card h5{
                font-size:18px;
            }

            .dashboard-card h3{
                font-size:26px;
            }

            .table-box h4{
                font-size:24px;
            }

            .table th,
            .table td{
                font-size:14px;
                padding:12px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <img src="../assets/Images/Logo.png" alt="Logo"/>
        <a href="dashboard.php">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="add-watch.php"> <i class="bi bi-plus-circle"></i> Add Watch </a>
        <a href="manage-watch.php"> <i class="bi bi-watch"></i> Manage Watch </a>
        <a href="orders.php"> <i class="bi bi-cart"></i> Orders </a>
        <a href="users.php"> <i class="bi bi-people"></i> Users </a>
        <a href="reports.php" class="active"> <i class="bi bi-bar-chart"></i> Reports </a>
        <a href="../logout.php"> <i class="bi bi-box-arrow-right"></i> Logout </a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Header Bar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h3>Reports</h3>
            <div class="admin-info text-end">
                <h5 class="mb-1">Welcome <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?></h5>
                <p class="mb-0">
                    <strong>Admin ID :</strong>
                    <?php echo isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : ''; ?>
                </p>
                <p class="mb-0">
                    <strong>Name :</strong>
                    <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>
                </p>
                <p class="mb-0">
                    <strong>Email :</strong>
                    <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>
                </p>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h5>Today's Sales</h5>
                    <h3>₹<?php echo number_format($today_sales, 2); ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h5>Monthly Sales</h5>
                    <h3>₹<?php echo number_format($monthly_sales, 2); ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h5>Yearly Sales</h5>
                    <h3>₹<?php echo number_format($yearly_sales, 2); ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h5>Revenue</h5>
                    <h3>₹<?php echo number_format($total_revenue, 2); ?></h3>
                </div>
            </div>
        </div>

        <!-- Sales Data Table -->
        <div class="table-box">
            <h4 class="text-center mb-4">Sales Report</h4>
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Orders</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                if (mysqli_num_rows($sales_report_result) > 0) {
                    while ($row = mysqli_fetch_assoc($sales_report_result)) { 
                        $formatted_date = date("d-m-Y", strtotime($row['order_date']));
                ?>
                    <tr>
                        <td><?php echo $formatted_date; ?></td>
                        <td><?php echo $row['total_orders']; ?></td>
                        <td>₹<?php echo number_format($row['total_amount'], 2); ?></td>
                    </tr>
                <?php 
                    }
                } else { ?>
                    <tr>
                        <td colspan="3" class="text-center">No sales report data available.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS & Custom Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>