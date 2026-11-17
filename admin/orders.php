<?php
    require_once("auth.php");
    include("../assets/includes/db.php");

    // Handle AJAX status update request
    if(isset($_POST['action']) && $_POST['action'] == 'update_status'){
        $order_id = intval($_POST['order_id']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        
        $update_query = "UPDATE orders SET order_status = '$status' WHERE order_id = '$order_id'";
        if(mysqli_query($conn, $update_query)){
            echo "success";
        } else {
            echo "error";
        }
        exit;
    }

    // Search and filter parameters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';

    // Dynamic SQL query
    $query = "SELECT * FROM orders WHERE 1=1";

    if(!empty($search)){
        $search_clean = mysqli_real_escape_string($conn, $search);
        $query .= " AND (order_id LIKE '%$search_clean%' OR customer_name LIKE '%$search_clean%' OR phone LIKE '%$search_clean%')";
    }

    if(!empty($status_filter) && $status_filter != 'All Status'){
        $status_clean = mysqli_real_escape_string($conn, $status_filter);
        $query .= " AND order_status = '$status_clean'";
    }

    $query .= " ORDER BY order_id DESC";
    $result = mysqli_query($conn, $query);

    // Return HTML rows for AJAX live search
    if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) { 
                $payment_status = strtoupper($row['payment_status']);
                $status = $row['order_status'];
        ?>
                <tr>
                    <td>#<?php echo $row['order_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td>₹<?php echo number_format($row['amount']); ?></td>
                    <td>
                        <?php if($payment_status == 'PAID' || $payment_status == 'SUCCESS'): ?>
                            <span class="badge bg-success">Paid</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">COD</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <select class="form-select status-select" data-order-id="<?php echo $row['order_id']; ?>">
                            <option value="Pending" <?php if($status == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Processing" <?php if($status == 'Processing') echo 'selected'; ?>>Processing</option>
                            <option value="Shipped" <?php if($status == 'Shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="Delivered" <?php if($status == 'Delivered') echo 'selected'; ?>>Delivered</option>
                        </select>
                    </td>
                    <td>
                        <a href="order-details.php?id=<?php echo $row['order_id']; ?>" class="btn btn-dark btn-sm">View</a>
                    </td>
                </tr>
        <?php 
            } 
        } else { 
        ?>
            <tr>
                <td colspan="7">No orders found.</td>
            </tr>
        <?php 
        }
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Rolex - Orders</title>

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

    <!-- CSS -->
    <style>
        /* Orders Style */
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
            font-family:"Cinzel",serif;
            font-weight:700;
        }

        /* Admin Info */
        .admin-info{
            text-align:right;
        }

        .admin-info h5{
            margin:0 0 8px;
            color:#111;
            font-family:"Cinzel",serif;
            font-size:20px;
            font-weight:600;
        }

        .admin-info p{
            margin:0;
            font-size:14px;
            color:#666;
            line-height:1.7;
            font-family:"Poppins",sans-serif;
        }

        .admin-info p strong{
            color:#222;
            font-weight:600;
        }

        /* Filter Box */
        .table-box{
            background:#fff;
            padding:25px;
            border:1px solid #e5e5e5;
            border-radius:14px;
            box-shadow:0 4px 12px rgba(0,0,0,.05);
        }

        .table-box h4{
            font-family:"Cinzel",serif;
            font-weight:700;
            color:#111;
        }

        /* Labels */
        .form-label{
            font-family:"Poppins",sans-serif;
            font-weight:500;
            color:#333;
            margin-bottom:8px;
        }

        /* Input */
        .form-control{
            height:48px;
            border-radius:10px;
            border:1px solid #dcdcdc;
            font-size:15px;
            font-family:"Poppins",sans-serif;
            box-shadow:none;
        }

        .form-control:focus{
            border-color:#000;
            box-shadow:none;
        }

        /* Select */
        .form-select{
            height:48px;
            border-radius:10px;
            border:1px solid #dcdcdc;
            font-size:15px;
            font-family:"Poppins",sans-serif;
            box-shadow:none;
        }

        .form-select:focus{
            border-color:#000;
            box-shadow:none;
        }

        /* Orders Table */
        .table{
            margin-bottom:0;
        }

        .table thead th{
            background:#000 !important;
            color:#fff !important;
            text-align:center;
            vertical-align:middle;
            font-family:"Cinzel",serif;
            font-weight:600;
            padding:15px;
        }

        .table tbody td{
            text-align:center;
            vertical-align:middle;
            padding:15px;
            font-family:"Poppins",sans-serif;
            color:#333;
        }

        .table-hover tbody tr{
            transition:.3s;
        }

        .table-hover tbody tr:hover{
            background:#f8f9fa;
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

        /* Paid Badge */
        .bg-success{
            background:#eaf8ee !important;
            color:#198754 !important;
            border-color:#b9e7c8 !important;
        }

        /* COD Badge */
        .bg-warning{
            background:#fff8e5 !important;
            color:#b8860b !important;
            border-color:#ffe08a !important;
        }

        /* Status Dropdown */
        .table .form-select{
            min-width:170px;
            height:42px;
            border-radius:8px;
            font-size:14px;
            font-family:"Poppins",sans-serif;
        }

        .table .form-select:focus{
            border-color:#000;
            box-shadow:none;
        }

        /* View Button */
        .btn-dark{
            border-radius:8px;
            padding:8px 18px;
            font-size:14px;
            font-family:"Poppins",sans-serif;
            transition:.3s;
        }

        .btn-dark:hover{
            transform:translateY(-2px);
        }

        /* Responsive Styles */
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
                gap:10px;
                text-align:center;
            }

            .admin-info{
                width:100%;
                text-align:left;
            }

            .table-box{
                padding:18px;
            }

            .table th,
            .table td{
                white-space:nowrap;
            }

            .table .form-select{
                min-width:140px;
            }

            .btn-dark{
                width:100%;
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
            <h3>Orders</h3>

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

        <!-- Filter Box -->
        <div class="table-box">
            <form id="orderFilterForm" onsubmit="return false;">
                <div class="row g-3 align-items-end">
                    <!-- Search -->
                    <div class="col-lg-8 col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text"
                               id="orderSearchInput"
                               name="search"
                               class="form-control"
                               placeholder="Search Order ID / Customer / Phone"
                               value="<?php echo htmlspecialchars($search); ?>"
                               autocomplete="off">
                    </div>

                    <!-- Status Filter -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Status Filter</label>
                        <select id="orderStatusFilter" name="status" class="form-select">
                            <option value="All Status" <?php if($status_filter == '' || $status_filter == 'All Status') echo 'selected'; ?>>All Status</option>
                            <option value="Pending" <?php if($status_filter == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Processing" <?php if($status_filter == 'Processing') echo 'selected'; ?>>Processing</option>
                            <option value="Shipped" <?php if($status_filter == 'Shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="Delivered" <?php if($status_filter == 'Delivered') echo 'selected'; ?>>Delivered</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="table-box mt-4">
            <h4 class="mb-4 text-center">Manage Orders</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Order Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="ordersTableBody">
                    <?php 
                    if($result && mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                            $payment_status = strtoupper($row['payment_status']);
                            $status = $row['order_status'];
                    ?>
                        <tr>
                            <td>#<?php echo $row['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td>₹<?php echo number_format($row['amount']); ?></td>
                            <td>
                                <?php if($payment_status == 'PAID' || $payment_status == 'SUCCESS'): ?>
                                    <span class="badge bg-success">Paid</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">COD</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <select class="form-select status-select" data-order-id="<?php echo $row['order_id']; ?>">
                                    <option value="Pending" <?php if($status == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Processing" <?php if($status == 'Processing') echo 'selected'; ?>>Processing</option>
                                    <option value="Shipped" <?php if($status == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                    <option value="Delivered" <?php if($status == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                </select>
                            </td>
                            <td>
                                <a href="order-details.php?id=<?php echo $row['order_id']; ?>" class="btn btn-dark btn-sm">View</a>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else { 
                    ?>
                        <tr>
                            <td colspan="7">No orders found.</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript for AJAX Operations -->
    <script>
        // Attach status change event listeners
        function attachStatusChangeEvent() {
            document.querySelectorAll('.status-select').forEach(select => {
                select.onchange = function() {
                    const orderId = this.getAttribute('data-order-id');
                    const newStatus = this.value;

                    const formData = new FormData();
                    formData.append('action', 'update_status');
                    formData.append('order_id', orderId);
                    formData.append('status', newStatus);

                    fetch('orders.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        if(data.trim() === 'success') {
                            alert('Order status updated successfully!');
                        } else {
                            alert('Failed to update status.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                };
            });
        }

        // Initialize status change listener on load
        attachStatusChangeEvent();

        // AJAX live search and filter logic
        let searchTimer = null;

        function fetchFilteredOrders() {
            const searchValue = document.getElementById('orderSearchInput').value;
            const statusValue = document.getElementById('orderStatusFilter').value;

            const xhr = new XMLHttpRequest();
            xhr.open('GET', `orders.php?search=${encodeURIComponent(searchValue)}&status=${encodeURIComponent(statusValue)}&ajax=1`, true);

            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('ordersTableBody').innerHTML = this.responseText;
                    // Re-attach status change events to newly loaded rows
                    attachStatusChangeEvent();
                }
            };

            xhr.send();
        }

        // Search input keyup event with debounce
        document.getElementById('orderSearchInput').addEventListener('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchFilteredOrders, 300);
        });

        // Filter dropdown change event
        document.getElementById('orderStatusFilter').addEventListener('change', fetchFilteredOrders);
    </script>
</body>
</html>