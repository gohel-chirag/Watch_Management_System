<?php
session_start();
require_once "assets/includes/config.php";
require_once "assets/includes/db.php";

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get Order ID from URL, session, or fetch latest order
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['id']);
} elseif (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];
} else {
    // Fetch latest order
    $latest_order = mysqli_query($conn, "SELECT order_id FROM orders WHERE user_id = '$user_id' ORDER BY order_id DESC LIMIT 1");
    if ($latest_order && mysqli_num_rows($latest_order) > 0) {
        $row = mysqli_fetch_assoc($latest_order);
        $order_id = $row['order_id'];
    } else {
        header("Location: my-orders.php");
        exit();
    }
}

// Fetch details from orders and user_addresses tables
$order_query = "SELECT o.*, a.name, a.phone, a.address, a.city, a.state, a.pincode 
                FROM orders o 
                LEFT JOIN user_addresses a ON o.address_id = a.address_id 
                WHERE o.order_id = '$order_id' AND o.user_id = '$user_id'";

$order_result = mysqli_query($conn, $order_query);

if (!$order_result || mysqli_num_rows($order_result) == 0) {
    header("Location: my-orders.php");
    exit();
}

$order = mysqli_fetch_assoc($order_result);

// Fetch items and images from order_items and watches tables
$items_query = "SELECT oi.*, w.watch_name, w.image 
                FROM order_items oi 
                JOIN watches w ON oi.watch_id = w.watch_id 
                WHERE oi.order_id = '$order_id'";

$items_result = mysqli_query($conn, $items_query);
?>

<!-- Order Details CSS -->
<style>
    /* Section Title */
    .section-title h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
    }

    /* Main Container Card */
    .order-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .order-card-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .order-card-header h4 {
        font-size: 22px;
        font-weight: 700;
        color: #111;
        margin: 0;
    }

    .order-card-header p {
        color: #666;
        margin: 5px 0 0 0;
        font-size: 14px;
    }

    /* Inner Detail Cards */
    .detail-box {
        background: #fdfdfd;
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        padding: 20px;
        height: auto;
    }

    .detail-box h5 {
        font-size: 16px;
        font-weight: 600;
        color: #111;
        border-bottom: 2px solid #c9a227;
        display: inline-block;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    /* Product Item Table / Row */
    .order-item-img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 5px;
        background: #fff;
    }

    .product-title {
        font-size: 16px;
        font-weight: 600;
        color: #111;
        margin: 0;
    }

    .badge-status {
        background: #fff8e1;
        color: #b78103;
        border: 1px solid #ffe082;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        display: inline-block;
    }

    .price-text {
        font-weight: 700;
        color: #000;
    }

    /* Gold Outline Button */
    .btn-outline-gold {
        border: 1px solid #000 !important;
        color: #000 !important;
        background: #fff !important;
        border-radius: 30px !important;
        padding: 10px 24px;
        font-weight: 500;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-outline-gold:hover {
        background: #000 !important;
        color: #fff !important;
        border-color: #000 !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .order-card {
            padding: 20px;
        }

        .btn-outline-gold {
            width: 100%;
            text-align: center;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Order Details Main Section -->
<section class="order-details-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>ORDER DETAILS</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="order-card">
                    <!-- Header Info -->
                    <div class="order-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h4>Order #ORD<?php echo htmlspecialchars($order['order_id']); ?></h4>
                            <p><i class="bi bi-calendar3 me-1"></i> Order Date: <?php echo isset($order['created_at']) ? date('d M Y', strtotime($order['created_at'])) : date('d M Y'); ?></p>
                        </div>
                        <div>
                            <span class="badge-status">
                                <i class="bi bi-hourglass-split me-1"></i> Status: <?php echo ucfirst(htmlspecialchars($order['order_status'] ?? 'Processing')); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Products List -->
                    <div class="detail-box mb-4">
                        <h5>PRODUCT INFORMATION</h5>
                        <?php 
                        $items_subtotal = 0;
                        if ($items_result && mysqli_num_rows($items_result) > 0) {
                            while ($item = mysqli_fetch_assoc($items_result)) {
                                $item_price = $item['price'] ?? 0;
                                $item_qty = $item['quantity'] ?? 1;
                                $items_subtotal += ($item_price * $item_qty);
                                
                                // Set image path
                                $img_name = $item['image'] ?? '';
                                $img_src = !empty($img_name) ? "assets/Images/watches/" . $img_name : "assets/Images/watches/watch-1.jpg";
                        ?>
                        <div class="d-flex align-items-center flex-wrap gap-3 py-2 border-bottom">
                            <div>
                                <img src="<?php echo htmlspecialchars($img_src); ?>" alt="<?php echo htmlspecialchars($item['watch_name'] ?? 'Watch'); ?>" class="order-item-img">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="product-title"><?php echo htmlspecialchars($item['watch_name'] ?? 'Watch'); ?></h6>
                                <small class="text-muted">Quantity: <?php echo $item_qty; ?></small>
                            </div>
                            <div class="text-end">
                                <span class="price-text fs-5">₹<?php echo number_format($item_price * $item_qty, 2); ?></span>
                            </div>
                        </div>
                        <?php 
                            }
                        } else {
                            $items_subtotal = $order['amount'] ?? 0;
                        ?>
                        <div class="d-flex align-items-center flex-wrap gap-3 py-2">
                            <div>
                                <img src="assets/Images/watches/watch-1.jpg" alt="Product" class="order-item-img">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="product-title">Ordered Item</h6>
                                <small class="text-muted">Quantity: 1</small>
                            </div>
                            <div class="text-end">
                                <span class="price-text fs-5">₹<?php echo number_format($order['amount'] ?? 0, 2); ?></span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Address & Payment Summary -->
                    <div class="row g-4 mb-4">
                        <!-- Shipping Address -->
                        <div class="col-md-6">
                            <div class="detail-box">
                                <h5>SHIPPING ADDRESS</h5>
                                <?php if (!empty($order['name'])): ?>
                                    <p class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($order['name']); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($order['address'])): ?>
                                    <p class="mb-1 text-muted"><?php echo htmlspecialchars($order['address']); ?></p>
                                <?php endif; ?>

                                <p class="mb-1 text-muted">
                                    <?php 
                                        $city = !empty($order['city']) ? htmlspecialchars($order['city']) : '';
                                        $state = !empty($order['state']) ? htmlspecialchars($order['state']) : '';
                                        echo implode(', ', array_filter([$city, $state]));
                                    ?>
                                </p>

                                <?php if (!empty($order['pincode'])): ?>
                                    <p class="mb-1 text-muted">Pincode: <?php echo htmlspecialchars($order['pincode']); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($order['phone'])): ?>
                                    <p class="mb-0 text-muted"><i class="bi bi-telephone me-1"></i> <?php echo htmlspecialchars($order['phone']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Payment Summary -->
                        <div class="col-md-6">
                            <div class="detail-box">
                                <h5>PAYMENT SUMMARY</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Item Price</span>
                                    <span>₹<?php echo number_format($items_subtotal, 2); ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping Charge</span>
                                    <span>₹100.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Payment Method</span>
                                    <span class="fw-bold"><?php echo htmlspecialchars($order['payment_method'] ?? 'Cash on Delivery'); ?></span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">Total Amount</span>
                                    <span class="price-text fs-4">₹<?php echo number_format(($order['amount'] ?? 0) + 100, 2); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center mt-4 d-flex justify-content-center gap-3 flex-wrap">
                        <a href="index.php" class="btn btn-outline-gold"><i class="bi bi-house-fill"></i> BACK TO HOME</a>
                        <a href="invoice.php?id=<?php echo $order['order_id']; ?>" target="_blank" class="btn btn-outline-gold">
                            <i class="bi bi-printer me-1"></i> INVOICE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>