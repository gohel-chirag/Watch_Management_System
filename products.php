<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    include 'assets/includes/db.php'; 

    // Read parameters from GET or Fallback to SESSION
    if (isset($_GET['ajax']) || isset($_GET['search']) || isset($_GET['sort'])) {
        $_SESSION['watch_filter'] = [
            'search'           => isset($_GET['search']) ? $_GET['search'] : '',
            'sort'             => isset($_GET['sort']) ? $_GET['sort'] : '',
            'gender'           => isset($_GET['gender']) ? $_GET['gender'] : '',
            'case_material'    => isset($_GET['case_material']) ? $_GET['case_material'] : '',
            'case_size'        => isset($_GET['case_size']) ? $_GET['case_size'] : '',
            'dial_color'       => isset($_GET['dial_color']) ? $_GET['dial_color'] : '',
            'movement'         => isset($_GET['movement']) ? $_GET['movement'] : '',
            'water_resistance' => isset($_GET['water_resistance']) ? $_GET['water_resistance'] : '',
            'availability'     => isset($_GET['availability']) ? $_GET['availability'] : ''
        ];
    }

    $saved = isset($_SESSION['watch_filter']) ? $_SESSION['watch_filter'] : [];

    $search           = isset($_GET['search']) ? $_GET['search'] : ($saved['search'] ?? '');
    $sort             = isset($_GET['sort']) ? $_GET['sort'] : ($saved['sort'] ?? '');
    $gender           = isset($_GET['gender']) ? $_GET['gender'] : ($saved['gender'] ?? '');
    $case_material    = isset($_GET['case_material']) ? $_GET['case_material'] : ($saved['case_material'] ?? '');
    $case_size        = isset($_GET['case_size']) ? $_GET['case_size'] : ($saved['case_size'] ?? '');
    $dial_color       = isset($_GET['dial_color']) ? $_GET['dial_color'] : ($saved['dial_color'] ?? '');
    $movement         = isset($_GET['movement']) ? $_GET['movement'] : ($saved['movement'] ?? '');
    $water_resistance = isset($_GET['water_resistance']) ? $_GET['water_resistance'] : ($saved['water_resistance'] ?? '');
    $availability     = isset($_GET['availability']) ? $_GET['availability'] : ($saved['availability'] ?? '');

    // Sanitization
    $s_search           = mysqli_real_escape_string($conn, $search);
    $s_sort             = mysqli_real_escape_string($conn, $sort);
    $s_gender           = mysqli_real_escape_string($conn, $gender);
    $s_case_material    = mysqli_real_escape_string($conn, $case_material);
    $s_case_size        = mysqli_real_escape_string($conn, $case_size);
    $s_dial_color       = mysqli_real_escape_string($conn, $dial_color);
    $s_movement         = mysqli_real_escape_string($conn, $movement);
    $s_water_resistance = mysqli_real_escape_string($conn, $water_resistance);
    $s_availability     = mysqli_real_escape_string($conn, $availability);

    // Build SQL Query
    $query = "SELECT * FROM watches WHERE 1=1";

    if (!empty($s_search)) {
        $query .= " AND watch_name LIKE '%$s_search%'";
    }

    // Filter by Gender
    if (!empty($s_gender)) {
        $query .= " AND description LIKE '%$s_gender%'";
    }

    // Filter by Collection / Model
    if (!empty($s_collection)) {
        $query .= " AND (description LIKE '%$s_collection%' OR watch_name LIKE '%$s_collection%')";
    }
    if (!empty($s_case_material)) {
        $query .= " AND description LIKE '%$s_case_material%'";
    }
    if (!empty($s_case_size)) {
        $query .= " AND description LIKE '%$s_case_size%'";
    }
    if (!empty($s_dial_color)) {
        $query .= " AND description LIKE '%$s_dial_color%'";
    }
    if (!empty($s_movement)) {
        $query .= " AND description LIKE '%$s_movement%'";
    }
    if (!empty($s_water_resistance)) {
        $query .= " AND description LIKE '%$s_water_resistance%'";
    }

    // Availability Filter
    if (!empty($s_availability)) {
        if ($s_availability == 'Out of Stock') {
            $query .= " AND (stock = 0 OR stock <= 0 OR description LIKE '%Out of Stock%')";
        } else {
            $query .= " AND (description LIKE '%$s_availability%' OR stock > 0)";
        }
    }

    // Sorting
    if ($s_sort == 'low_price') {
        $query .= " ORDER BY price ASC";
    } elseif ($s_sort == 'high_price') {
        $query .= " ORDER BY price DESC";
    } else {
        $query .= " ORDER BY watch_id DESC";
    }

    $result = mysqli_query($conn, $query);

    // AJAX Response handling
    if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) { 
        ?>
            <!-- Product Card -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card product-card h-100 w-100 d-flex flex-column justify-content-between">
                    <img src="assets/Images/watches/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['watch_name']); ?>">
                    <div class="card-body d-flex flex-column justify-content-between p-0 pt-3">
                        <div>
                            <h5><?php echo htmlspecialchars($row['watch_name']); ?></h5>
                            <p class="price">₹<?php echo number_format($row['price'], 2); ?></p>
                            <p class="rating">★★★★★</p>
                        </div>
                        <a href="product-details.php?id=<?php echo $row['watch_id']; ?>" class="btn btn-primary w-100 mt-auto">View Details</a>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
            echo "<div class='col-12 text-center'><p>No products found matching your search.</p></div>";
        }
        exit;
    }
?>

<!-- Styling -->
<style>
    .filter-box {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
    }

    .filter-box .form-control,
    .filter-box .form-select {
        height: 45px;
        border-radius: 30px;
        border: 1px solid #ddd;
        padding: 0 18px;
        font-size: 14px;
    }

    .filter-box .form-control:focus,
    .filter-box .form-select:focus {
        border-color: #000;
        box-shadow: none;
    }

    .btn-reset {
        height: 45px;
        border-radius: 30px !important;
        border: 1px solid #000 !important;
        font-size: 14px;
        font-weight: 500;
        transition: .3s;
    }

    .btn-reset:hover {
        background: #000000 !important;
        color: white !important;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 14px;
        padding: 18px;
        text-align: center;
        overflow: hidden;
        transition: .3s;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
    }

    .product-card:hover {
        transform: translateY(-6px);
        border-color: #000;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .12);
    }

    .product-card img {
        width: 100%;
        height: 230px;
        object-fit: contain;
        transition: .3s;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card h5 {
        margin-top: 15px;
        font-size: 18px;
        font-weight: 600;
        color: #111;
    }

    .price {
        font-size: 22px;
        font-weight: 700;
        color: #000;
        margin: 10px 0;
    }

    .rating {
        color: black;
        font-size: 20px;
        margin-bottom: 15px;
    }

    .product-card .btn {
        border: 1px solid #000;
        color: #000;
        background: #fff;
        border-radius: 30px;
        padding: 10px 20px;
        font-weight: 500;
        transition: .3s;
    }

    .product-card .btn:hover {
        background: #000 !important;
        color: #fff !important;
        border-color: #000 !important;
    }

    @media(max-width:768px) {
        .filter-box {
            padding: 15px;
        }

        .product-card {
            padding: 15px;
        }

        .product-card img {
            height: 180px;
        }

        .product-card h5 {
            font-size: 16px;
        }

        .price {
            font-size: 20px;
        }

        .product-card .btn {
            width: 100%;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Product Main -->
<div class="container my-5">
    <!-- Advanced Search & Filter -->
    <div class="filter-box mb-4">
        <form id="filterForm" onsubmit="return false;">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" id="searchInput" name="search" class="form-control filter-input" placeholder="Search Product" value="<?php echo htmlspecialchars($search); ?>" autocomplete="off">
                </div>
                <div class="col-md-4">
                    <select id="sortSelect" name="sort" class="form-select filter-input">
                        <option value="">Sort By</option>
                        <option value="low_price" <?php echo ($sort == 'low_price') ? 'selected' : ''; ?>>Low Price</option>
                        <option value="high_price" <?php echo ($sort == 'high_price') ? 'selected' : ''; ?>>High Price</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="genderSelect" name="gender" class="form-select filter-input">
                        <option value="">Gender</option>
                        <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="caseMaterialSelect" name="case_material" class="form-select filter-input">
                        <option value="">Case Material</option>
                        <option value="Gold" <?php echo ($case_material == 'Gold') ? 'selected' : ''; ?>>Gold</option>
                        <option value="Stainless Steel" <?php echo ($case_material == 'Stainless Steel') ? 'selected' : ''; ?>>Stainless Steel</option>
                        <option value="Titanium" <?php echo ($case_material == 'Titanium') ? 'selected' : ''; ?>>Titanium</option>
                        <option value="Leather" <?php echo ($case_material == 'Leather') ? 'selected' : ''; ?>>Leather</option>
                        <option value="Silver" <?php echo ($case_material == 'Silver') ? 'selected' : ''; ?>>Silver</option>
                        <option value="Rose Gold" <?php echo ($case_material == 'Rose Gold') ? 'selected' : ''; ?>>Rose Gold</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="caseSizeSelect" name="case_size" class="form-select filter-input">
                        <option value="">Case Size</option>
                        <option value="38mm" <?php echo ($case_size == '38mm') ? 'selected' : ''; ?>>38mm</option>
                        <option value="40mm" <?php echo ($case_size == '40mm') ? 'selected' : ''; ?>>40mm</option>
                        <option value="42mm" <?php echo ($case_size == '42mm') ? 'selected' : ''; ?>>42mm</option>
                        <option value="44mm" <?php echo ($case_size == '44mm') ? 'selected' : ''; ?>>44mm</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="dialColorSelect" name="dial_color" class="form-select filter-input">
                        <option value="">Dial Color</option>
                        <option value="Black" <?php echo ($dial_color == 'Black') ? 'selected' : ''; ?>>Black</option>
                        <option value="Blue" <?php echo ($dial_color == 'Blue') ? 'selected' : ''; ?>>Blue</option>
                        <option value="White" <?php echo ($dial_color == 'White') ? 'selected' : ''; ?>>White</option>
                        <option value="Gold" <?php echo ($dial_color == 'Gold') ? 'selected' : ''; ?>>Gold</option>
                        <option value="Silver" <?php echo ($dial_color == 'Silver') ? 'selected' : ''; ?>>Silver</option>
                        <option value="Green" <?php echo ($dial_color == 'Green') ? 'selected' : ''; ?>>Green</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="waterResistanceSelect" name="water_resistance" class="form-select filter-input">
                        <option value="">Water Resistance</option>
                        <option value="50m" <?php echo ($water_resistance == '50m') ? 'selected' : ''; ?>>50m (5 ATM)</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="availabilitySelect" name="availability" class="form-select filter-input">
                        <option value="">Availability</option>
                        <option value="In Stock" <?php echo ($availability == 'In Stock') ? 'selected' : ''; ?>>In Stock</option>
                        <option value="Out of Stock" <?php echo ($availability == 'Out of Stock') ? 'selected' : ''; ?>>Out of Stock</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="button" id="resetBtn" class="btn btn-reset w-100" onclick="resetFilters()">Reset Filters</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="row g-4" id="productGrid">
        <?php 
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) { 
        ?>
            <!-- Product Card -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card product-card h-100 w-100 d-flex flex-column justify-content-between">
                    <img src="assets/Images/watches/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['watch_name']); ?>">
                    <div class="card-body d-flex flex-column justify-content-between p-0 pt-3">
                        <div>
                            <h5><?php echo htmlspecialchars($row['watch_name']); ?></h5>
                            <p class="price">₹<?php echo number_format($row['price'], 2); ?></p>
                            <p class="rating">★★★★★</p>
                        </div>
                        <a href="product-details.php?id=<?php echo $row['watch_id']; ?>" class="btn btn-primary w-100 mt-auto">View Details</a>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
            echo "<div class='col-12 text-center'><p>No products found matching your search.</p></div>";
        }
        ?>
    </div>
</div>

<!-- AJAX Live Filter Script -->
<script>
    let searchTimeout = null;

    function fetchProducts() {
        const searchVal = document.getElementById('searchInput').value;
        const sortVal = document.getElementById('sortSelect').value;
        const genderVal = document.getElementById('genderSelect').value;
        const caseMaterialVal = document.getElementById('caseMaterialSelect').value;
        const caseSizeVal = document.getElementById('caseSizeSelect').value;
        const dialColorVal = document.getElementById('dialColorSelect').value;
        const waterResistanceVal = document.getElementById('waterResistanceSelect').value;
        const availabilityVal = document.getElementById('availabilitySelect').value;

        const params = new URLSearchParams({
            search: searchVal,
            sort: sortVal,
            gender: genderVal,
            case_material: caseMaterialVal,
            case_size: caseSizeVal,
            dial_color: dialColorVal,
            water_resistance: waterResistanceVal,
            availability: availabilityVal,
            ajax: 1
        });

        const updatedUrl = '?' + params.toString().replace('&ajax=1', '');
        history.replaceState(null, '', updatedUrl);

        const xhr = new XMLHttpRequest();
        xhr.open('GET', '?' + params.toString(), true);
        
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('productGrid').innerHTML = this.responseText;
            }
        };

        xhr.send();
    }

    function resetFilters() {
        document.getElementById('filterForm').reset();
        fetchProducts();
    }

    document.querySelectorAll('.filter-input').forEach(element => {
        if (element.tagName.toLowerCase() === 'input') {
            element.addEventListener('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(fetchProducts, 300);
            });
        } else if (element.tagName.toLowerCase() === 'select') {
            element.addEventListener('change', fetchProducts);
        }
    });
</script>

<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>