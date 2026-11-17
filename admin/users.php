<?php
    require_once("auth.php");
    include("../assets/includes/db.php");

    // Handle user deletion
    if(isset($_GET['delete_id'])){
        $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
        mysqli_query($conn, "DELETE FROM users WHERE id='$delete_id'");
        header("Location: users.php");
        exit();
    }

    // Handle search input
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    $sql = "SELECT * FROM users WHERE 1=1";
    if(!empty($search)) {
        $search_clean = mysqli_real_escape_string($conn, $search);
        $sql .= " AND (id LIKE '%$search_clean%' OR name LIKE '%$search_clean%' OR email LIKE '%$search_clean%' OR phone LIKE '%$search_clean%')";
    }
    $sql .= " ORDER BY id DESC";

    $select_users = mysqli_query($conn, $sql);

    // Return HTML fragment for AJAX requests
    if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
        if($select_users && mysqli_num_rows($select_users) > 0) {
            while($row = mysqli_fetch_assoc($select_users)) { 
                $formatted_date = date('d-m-Y h:i A', strtotime($row['created_at']));
        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo $formatted_date; ?></td>
                    <td align="center">
                        <a href="users.php?delete_id=<?php echo $row['id']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this user?');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
        <?php 
            }
        } else { 
        ?>
            <tr>
                <td colspan="6" class="text-center">No Users Found</td>
            </tr>
        <?php 
        }
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Rolex - Users</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/Images/favicon.png">

    <style>
/* Users Page Styles */
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
    margin: 30px auto 30px;
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

/* Admin Info */
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
    font-weight: 600;
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

/* Search Box */
.search-box {
    width: 280px;
}

.search-box input {
    border: 1px solid #dcdcdc;
    border-radius: 30px;
    padding: 10px 18px;
    box-shadow: none;
    font-size: 15px;
}

.search-box input:focus {
    border-color: #000;
    box-shadow: none;
}

/* Table */
.table {
    margin-bottom: 0;
}

.table th {
    font-family: "Cinzel", serif;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
    font-family: "Poppins", sans-serif;
}

/* Delete Button */
.btn-danger {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .3s;
}

.btn-danger:hover {
    transform: scale(1.08);
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

    .search-box {
        width: 100%;
        margin-top: 15px;
    }

    .table-box .d-flex {
        flex-direction: column;
        align-items: stretch !important;
    }

    .table-responsive {
        overflow-x: auto;
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
        <a href="orders.php"> <i class="bi bi-cart"></i> Orders </a>
        <a href="users.php" class="active"> <i class="bi bi-people"></i> Users </a>
        <a href="reports.php"> <i class="bi bi-bar-chart"></i> Reports </a>
        <a href="../logout.php"> <i class="bi bi-box-arrow-right"></i> Logout </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h3>Users</h3>
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

        <!-- Users Table -->
        <div class="table-box">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Users List</h4>
                <div class="search-box">
                    <input type="text" 
                           id="userSearchInput" 
                           class="form-control" 
                           placeholder="Search User (ID, Name, Email, Phone)"
                           value="<?php echo htmlspecialchars($search); ?>"
                           autocomplete="off">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <?php 
                        if($select_users && mysqli_num_rows($select_users) > 0) {
                            while($row = mysqli_fetch_assoc($select_users)) { 
                                $formatted_date = date('d-m-Y h:i A', strtotime($row['created_at']));
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo $formatted_date; ?></td>
                            <td align="center">
                                <a href="users.php?delete_id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this user?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else { 
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">No Users Found</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Live Search Script -->
    <script>
        let searchTimer = null;

        document.getElementById('userSearchInput').addEventListener('keyup', function() {
            clearTimeout(searchTimer);
            const searchValue = this.value;

            // Debounce implementation (300ms delay)
            searchTimer = setTimeout(() => {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `users.php?search=${encodeURIComponent(searchValue)}&ajax=1`, true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('usersTableBody').innerHTML = this.responseText;
                    }
                };

                xhr.send();
            }, 300);
        });
    </script>
</body>
</html>