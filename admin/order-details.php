<?php
    require_once("auth.php");
    include("../assets/includes/db.php");

    // Get order_id from URL
    $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if($order_id <= 0) {
        header("Location: orders.php");
        exit;
    }

    // Fetch order, customer, and address details
    $order_query = "SELECT o.*, u.email as user_email, 
                           addr.address, addr.city, addr.state, addr.pincode 
                    FROM orders o
                    LEFT JOIN users u ON o.user_id = u.id
                    LEFT JOIN user_addresses addr ON o.address_id = addr.address_id
                    WHERE o.order_id = '$order_id'";

    $order_res = mysqli_query($conn, $order_query);

    if(!$order_res || mysqli_num_rows($order_res) == 0) {
        header("Location: orders.php");
        exit;
    }

    $order = mysqli_fetch_assoc($order_res);

    // Fetch ordered items
    $items_query = "SELECT oi.*, w.watch_name, w.image 
                    FROM order_items oi 
                    JOIN watches w ON oi.watch_id = w.watch_id 
                    WHERE oi.order_id = '$order_id'";
    $items_res = mysqli_query($conn, $items_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>

    <title>Rolex - Order Details</title>

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

    <style>
        /* Body */
        html {
            overflow-y: scroll;
        }
        body{
            background:#f8f9fa;
            font-family:Arial, sans-serif;
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
            margin:30px auto 30px;
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
            background:#fff;
            padding:18px 25px;
            border-radius:14px;
            border:1px solid #e5e5e5;
            box-shadow:0 4px 12px rgba(0,0,0,.05);
            margin-bottom:30px;
        }

        .top-navbar h3{
            margin:0;
            color:#111;
            font-family:"Cinzel", serif;
            font-weight:700;
        }

        .admin-info{
            text-align:right;
        }

        .admin-info h5{
            margin:0 0 8px;
            color:#111;
            font-family:"Cinzel", serif;
            font-weight:600;
            font-size:20px;
        }

        .admin-info p{
            margin:0;
            font-size:14px;
            color:#666;
            line-height:1.7;
            font-family:"Poppins", sans-serif;
        }

        .admin-info p strong{
            color:#222;
            font-weight:600;
        }

        /* Details Card */
        .details-card{
            background:#fff;
            border:1px solid #e5e5e5;
            border-radius:14px;
            padding:25px;
            box-shadow:0 4px 12px rgba(0,0,0,.05);
            transition:.3s;
            height:100%;
        }

        .details-card:hover{
            transform:translateY(-5px);
            border-color:#000;
            box-shadow:0 10px 20px rgba(0,0,0,.10);
        }

        .details-card h4{
            font-family:"Cinzel", serif;
            color:#111;
            font-weight:700;
            margin-bottom:20px;
            padding-bottom:12px;
            border-bottom:1px solid #ececec;
        }

        /* Tables */
        .table{
            margin-bottom:0;
        }

        .table tr{
            border-bottom:1px solid #f1f1f1;
        }

        .table tr:last-child{
            border-bottom:none;
        }

        .table th{
            width:40%;
            font-family:"Cinzel", serif;
            font-weight:600;
            color:#222;
            padding:14px 0;
            vertical-align:middle;
        }

        .table td{
            font-family:"Poppins", sans-serif;
            color:#555;
            padding:14px 0;
            vertical-align:middle;
        }

        /* Badges */
        .badge{
            padding:8px 14px;
            border-radius:20px;
            font-size:13px;
            font-weight:500;
            letter-spacing:.3px;
            border:1px solid transparent;
        }

        .bg-success{
            background:#eaf8ee !important;
            color:#198754 !important;
            border-color:#b9e7c8 !important;
        }

        .bg-warning{
            background:#fff8e5 !important;
            color:#b8860b !important;
            border-color:#ffe08a !important;
        }

        .bg-danger{
            background:#fdecec !important;
            color:#dc3545 !important;
            border-color:#f5b8bf !important;
        }

        .bg-primary{
            background:#eef4ff !important;
            color:#0d6efd !important;
            border-color:#bcd4ff !important;
        }

        .bg-secondary{
            background:#f3f4f6 !important;
            color:#6c757d !important;
            border-color:#d6d8db !important;
        }

        /* Responsive */
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

            .top-navbar{
                flex-direction:column;
                align-items:flex-start !important;
                gap:15px;
            }

            .admin-info{
                width:100%;
                text-align:left;
            }

            .details-card{
                margin-bottom:20px;
            }

            .table th,
            .table td{
                display:block;
                width:100%;
                padding:8px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="../assets/Images/Logo.png" alt="Logo"/>
        <a href="dashboard.php">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="add-watch.php"> <i class="bi bi-plus-circle"></i> Add Watch </a>
        <a href="manage-watch.php"> <i class="bi bi-watch"></i> Manage Watch </a>
        <a href="orders.php" class="active"> <i class="bi bi-cart"></i> Orders </a>
        <a href="users.php"> <i class="bi bi-people"></i> Users </a>
        <a href="reports.php"> <i class="bi bi-bar-chart"></i> Reports </a>
        <a href="../logout.php"> <i class="bi bi-box-arrow-right"></i> Logout </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h3>Order Details</h3>
            <div class="admin-info text-end">
                <h5>Welcome <?php echo $_SESSION['name']; ?></h5>
                <p>
                    <strong>Admin ID :</strong>
                    <?php echo isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : ''; ?>
                </p>
                <p>
                    <strong>Email :</strong>
                    <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Order Information -->
            <div class="col-lg-6 mb-4">
                <div class="details-card">
                    <h4>Order Information</h4>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Order ID</th>
                            <td>: #ORD<?php echo $order['order_id']; ?></td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>: <?php echo date('d-m-Y', strtotime($order['created_at'])); ?></td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td>: 
                                <?php 
                                    $st = $order['order_status'];
                                    if($st == 'Delivered') {
                                        echo '<span class="badge bg-success">Delivered</span>';
                                    } elseif($st == 'Pending') {
                                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                                    } elseif($st == 'Shipped' || $st == 'Processing') {
                                        echo '<span class="badge bg-primary">'.$st.'</span>';
                                    } else {
                                        echo '<span class="badge bg-danger">'.$st.'</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>: ₹<?php echo number_format($order['amount']); ?></td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td>: 
                                <span class="badge bg-warning text-dark">COD</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="col-lg-6 mb-4">
                <div class="details-card">
                    <h4>Customer Details</h4>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Customer Name</th>
                            <td>: <?php echo htmlspecialchars($order['customer_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: <?php echo htmlspecialchars($order['user_email'] ? $order['user_email'] : 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>: <?php echo htmlspecialchars($order['phone']); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>: <?php echo htmlspecialchars($order['address'] ? $order['address'] : 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>: <?php echo htmlspecialchars($order['city'] ? $order['city'] : 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>: <?php echo htmlspecialchars($order['state'] ? $order['state'] : 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <th>Pincode</th>
                            <td>: <?php echo htmlspecialchars($order['pincode'] ? $order['pincode'] : 'N/A'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Ordered Items Table -->
            <div class="col-12 mb-4">
                <div class="details-card">
                    <h4>Ordered Items</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table">
                                <tr>
                                    <th>Image</th>
                                    <th>Watch Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($items_res && mysqli_num_rows($items_res) > 0) {
                                    while($item = mysqli_fetch_assoc($items_res)) {
                                        $subtotal = $item['price'] * $item['quantity'];
                                ?>
                                <tr>
                                    <td>
                                        <!-- Dynamic image path -->
                                        <img src="../assets/Images/watches/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['watch_name']); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                                    </td>
                                    <td><?php echo htmlspecialchars($item['watch_name']); ?></td>
                                    <td>₹<?php echo number_format($item['price']); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>₹<?php echo number_format($subtotal); ?></td>
                                </tr>
                                <?php 
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="5">No items found for this order.</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>