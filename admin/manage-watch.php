<?php
    require_once("auth.php");
    include("../assets/includes/db.php");

    // Delete watch
    if (isset($_GET['delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
        
        $img_query = "SELECT image FROM watches WHERE watch_id = '$delete_id'";
        $img_result = mysqli_query($conn, $img_query);
        if ($img_row = mysqli_fetch_assoc($img_result)) {
            $image_path = "../assets/Images/watches/" . $img_row['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $delete_query = "DELETE FROM watches WHERE watch_id = '$delete_id'";
        if (mysqli_query($conn, $delete_query)) {
            header("Location: manage-watch.php?msg=deleted");
            exit();
        }
    }

    // Search and sort
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    $query = "SELECT * FROM watches WHERE 1=1";

    if (!empty($search)) {
        $query .= " AND watch_name LIKE '%$search%'";
    }

    if ($sort == 'low_price') {
        $query .= " ORDER BY price ASC";
    } elseif ($sort == 'high_price') {
        $query .= " ORDER BY price DESC";
    } else {
        $query .= " ORDER BY watch_id DESC";
    }

    $result = mysqli_query($conn, $query);

    // AJAX response
    if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) { 
            ?>
                <tr>
                    <td><img src="../assets/Images/watches/<?php echo $row['image']; ?>" class="img-thumbnail" alt="<?php echo $row['watch_name']; ?>"></td>
                    <td><?php echo $row['watch_name']; ?></td>
                    <td>Rolex</td>
                    <td>₹<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                        <?php if ($row['stock'] > 0): ?>
                            <span class="badge bg-success">In Stock</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit-watch.php?id=<?php echo $row['watch_id']; ?>" class="btn btn-sm btn-dark">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                    <td>
                        <a href="manage-watch.php?delete_id=<?php echo $row['watch_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this watch?');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php 
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>No watches found.</td></tr>";
        }
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Rolex - Manage Watch</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&amp;family=Poppins:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/Images/favicon.png">

    <!-- CSS -->
    <style>
        html {
            overflow-y: scroll;
        }
        body {
            background: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background: #fff;
            border-right: 1px solid #e5e5e5;
            padding: 20px;
            box-shadow: 4px 0 12px rgba(0,0,0,.05);
        }
        .sidebar img {
            width: 120px;
            display: block;
            margin: 30px auto;
        }
        .sidebar a {
            display: block;
            color: #333;
            text-decoration: none;
            padding: 12px 30px;
            border: 1px solid #000;
            border-radius: 30px;
            margin-bottom: 8px;
            font-size: 15px;
            transition: .3s;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: #000;
            color: #fff;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            padding: 18px 25px;
            border-radius: 14px;
            border: 1px solid #e5e5e5;
            box-shadow: 0 4px 12px rgba(0,0,0,.05);
            margin-bottom: 30px;
        }
        .top-navbar h3 {
            margin: 0;
            color: #111;
            font-family: "Cinzel", serif;
            font-weight: 700;
        }
        .admin-info {
            text-align: right;
        }
        .admin-info h5 {
            margin: 0 0 8px;
            color: #111;
            font-family: "Cinzel", serif;
            font-size: 20px;
            font-weight: 600;
        }
        .admin-info p {
            margin: 0;
            font-size: 14px;
            color: #666;
            line-height: 1.7;
            font-family: "Poppins", sans-serif;
        }
        .admin-info p strong {
            color: #222;
        }

        /* Filter Card */
        .filter-card {
            background: #fff;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #e5e5e5;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,.05);
        }

        /* Form Inputs */
        .form-control,
        .form-select {
            height: 48px;
            border: 1px solid #dcdcdc;
            border-radius: 10px;
            box-shadow: none;
            font-size: 15px;
            padding: 10px 15px;
            transition: .3s;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #000;
            box-shadow: none;
        }

        /* Table Box */
        .table-box {
            background: #fff;
            padding: 25px;
            border: 1px solid #e5e5e5;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,.05);
        }
        .table-box h4 {
            font-family: "Cinzel", serif;
            font-weight: 700;
            color: #111;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            font-family: "Cinzel", serif;
            vertical-align: middle;
            white-space: nowrap;
        }
        .table td {
            vertical-align: middle;
        }

        /* Thumbnail Image */
        .img-thumbnail {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #fff;
        }

        /* Status Badges */
        .badge {
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .3px;
            border: 1px solid transparent;
        }
        .bg-success {
            background: #eaf8ee !important;
            color: #198754 !important;
            border-color: #b9e7c8 !important;
        }
        .bg-danger {
            background: #fdecec !important;
            color: #dc3545 !important;
            border-color: #f5b8bf !important;
        }

        /* Buttons */
        .btn-sm {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: .3s;
        }
        .btn-dark:hover,
        .btn-danger:hover {
            transform: translateY(-2px);
        }

        /* Responsive Styles */
        @media(max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 15px;
            }
            .sidebar img {
                width: 100px;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            .top-navbar {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 15px;
            }
            .admin-info {
                width: 100%;
                text-align: left;
            }
            .filter-card,
            .table-box {
                padding: 20px;
            }
            .table {
                min-width: 850px;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="../assets/Images/Logo.png" alt="Logo"/>
        <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="add-watch.php"><i class="bi bi-plus-circle"></i> Add Watch</a>
        <a href="manage-watch.php" class="active"><i class="bi bi-watch"></i> Manage Watch</a>
        <a href="orders.php"><i class="bi bi-cart"></i> Orders</a>
        <a href="users.php"><i class="bi bi-people"></i> Users</a>
        <a href="reports.php"><i class="bi bi-bar-chart"></i> Reports</a>
        <a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                Watch deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Search & Filter -->
        <div class="filter-card">
            <div class="row g-3">
                <div class="col-lg-8">
                    <input type="text" id="adminSearchInput" class="form-control" placeholder="Search Watch..." autocomplete="off">
                </div>
                <div class="col-lg-4">
                    <select id="adminSortSelect" class="form-select">
                        <option value="">Sort By</option>
                        <option value="low_price">Low Price</option>
                        <option value="high_price">High Price</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-box">
            <h4 class="mb-4">Manage Watches</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="adminWatchTableBody">
                    <?php 
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { 
                    ?>
                        <tr class="text-center">
                            <td><img src="../assets/Images/watches/<?php echo $row['image']; ?>" class="img-thumbnail" alt="<?php echo $row['watch_name']; ?>"></td>
                            <td><?php echo $row['watch_name']; ?></td>
                            <td>Rolex</td>
                            <td>₹<?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td>
                                <?php if ($row['stock'] > 0): ?>
                                    <span class="badge bg-success">In Stock</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Out of Stock</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="edit-watch.php?id=<?php echo $row['watch_id']; ?>" class="btn btn-sm btn-dark">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="manage-watch.php?delete_id=<?php echo $row['watch_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this watch?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No watches found.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

    <!-- Live Search AJAX -->
    <script>
        let searchTimer = null;

        function fetchAdminWatches() {
            const searchValue = document.getElementById('adminSearchInput').value;
            const sortValue = document.getElementById('adminSortSelect').value;

            const xhr = new XMLHttpRequest();
            xhr.open('GET', `manage-watch.php?search=${encodeURIComponent(searchValue)}&sort=${encodeURIComponent(sortValue)}&ajax=1`, true);

            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('adminWatchTableBody').innerHTML = this.responseText;
                }
            };

            xhr.send();
        }

        document.getElementById('adminSearchInput').addEventListener('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchAdminWatches, 300);
        });

        document.getElementById('adminSortSelect').addEventListener('change', fetchAdminWatches);
    </script>
</body>
</html>