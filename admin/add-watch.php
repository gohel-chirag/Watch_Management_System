<?php
    require_once("auth.php");
    include("../assets/includes/db.php");

    $message = "";
    $msg_type = "";

    // Handle form submission
    if (isset($_POST['save_watch'])) {
        $watch_name  = mysqli_real_escape_string($conn, $_POST['watch_name']);
        $price       = mysqli_real_escape_string($conn, $_POST['price']);
        $stock       = mysqli_real_escape_string($conn, $_POST['stock']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        // Image details
        $image_name = $_FILES['image']['name'];
        $image_tmp  = $_FILES['image']['tmp_name'];
        $image_ext  = pathinfo($image_name, PATHINFO_EXTENSION);

        // Generate unique image name
        $new_image_name = time() . "_" . rand(1000, 9999) . "." . $image_ext;
        $upload_dir     = "../assets/Images/watches/";

        // Create directory if not exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $target_file = $upload_dir . $new_image_name;

        // Move image and insert into DB
        if (move_uploaded_file($image_tmp, $target_file)) {
            $sql = "INSERT INTO watches (watch_name, price, stock, description, image) 
                    VALUES ('$watch_name', '$price', '$stock', '$description', '$new_image_name')";

            if (mysqli_query($conn, $sql)) {
                $message  = "Watch added successfully!";
                $msg_type = "success";
            } else {
                $message  = "Database Error: " . mysqli_error($conn);
                $msg_type = "danger";
            }
        } else {
            $message  = "Failed to upload image.";
            $msg_type = "danger";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Rolex - Add Watch</title>

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

    <!-- Custom CSS -->
    <style>
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

        /* Form Card */
        .form-card{
            background:#fff;
            border:1px solid #e5e5e5;
            border-radius:14px;
            padding:30px;
            box-shadow:0 4px 12px rgba(0,0,0,.05);
        }
        .form-card h4{
            font-family:"Cinzel",serif;
            font-weight:700;
            color:#111;
        }

        /* Label */
        .form-label{
            font-weight:600;
            color:#333;
            margin-bottom:8px;
            font-family:"Poppins",sans-serif;
        }

        /* Form Inputs */
        .form-control,
        .form-select{
            height:48px;
            border-radius:10px;
            border:1px solid #dcdcdc;
            box-shadow:none;
            font-size:15px;
            padding:10px 15px;
            transition:.3s;
        }
        .form-control:focus,
        .form-select:focus{
            border-color:#000;
            box-shadow:none;
        }
        textarea.form-control{
            height:auto;
            resize:none;
            padding:15px;
        }

        /* File Upload */
        input[type=file]{
            padding:10px;
        }

        /* Buttons */
        .btn-dark{
            border-radius:30px;
            padding:12px 35px;
            font-size:15px;
            font-weight:600;
            transition:.3s;
        }
        .btn-dark:hover{
            transform:translateY(-2px);
        }

        /* Preview Card */
        .preview-card{
            background:#fff;
            border:1px solid #e5e5e5;
            border-radius:14px;
            padding:30px;
            box-shadow:0 4px 12px rgba(0,0,0,.05);
            height:100%;
        }
        .preview-card h4{
            font-family:"Cinzel",serif;
            font-weight:700;
            color:#111;
        }

        /* Preview Box */
        .preview-box{
            height:380px;
            border:2px dashed #cfcfcf;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            background:#fafafa;
            overflow:hidden;
        }
        .preview-box i{
            font-size:70px;
            color:#999;
            margin-bottom:15px;
        }
        .preview-box p{
            margin:0;
            color:#777;
            font-size:15px;
            font-family:"Poppins",sans-serif;
        }
        .preview-box img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        /* Responsive Styles */
        @media(max-width:992px){
            .preview-card{
                margin-top:20px;
            }
        }
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
            .form-card,
            .preview-card{
                padding:20px;
            }
            .preview-box{
                height:250px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="../assets/Images/Logo.png" alt="Logo"/>
        <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="add-watch.php" class="active"><i class="bi bi-plus-circle"></i> Add Watch</a>
        <a href="manage-watch.php"><i class="bi bi-watch"></i> Manage Watch</a>
        <a href="orders.php"><i class="bi bi-cart"></i> Orders</a>
        <a href="users.php"><i class="bi bi-people"></i> Users</a>
        <a href="reports.php"><i class="bi bi-bar-chart"></i> Reports</a>
        <a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Alert Message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show mb-4" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form and Preview Section -->
        <div class="row g-4">
            <!-- Form Card -->
            <div class="col-lg-8">
                <div class="form-card">
                    <h4 class="mb-4">Add New Watch</h4>

                    <form action="add-watch.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Watch Name</label>
                            <input type="text" name="watch_name" class="form-control" placeholder="Enter Watch Name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter Price" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control" placeholder="Enter Stock" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="5" class="form-control" placeholder="Enter Watch Description" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Upload Image</label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" required>
                        </div>

                        <button type="submit" name="save_watch" class="btn btn-dark px-5">
                            <i class="bi bi-check-circle"></i> Save Watch
                        </button>
                    </form>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <div class="preview-card">
                    <h4 class="mb-4 text-center">Image Preview</h4>

                    <div class="preview-box" id="previewBox">
                        <i class="bi bi-image"></i>
                        <p>Preview will appear here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Image Preview Script -->
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewBox = document.getElementById('previewBox');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewBox.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            } else {
                previewBox.innerHTML = `
                    <i class="bi bi-image"></i>
                    <p>Preview will appear here</p>
                `;
            }
        });
    </script>
</body>
</html>