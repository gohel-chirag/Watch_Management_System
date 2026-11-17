<?php
session_start();
include 'assets/includes/db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get latest order ID if not present in session
if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];
} else {
    $latest_order = mysqli_query($conn, "SELECT order_id FROM orders WHERE user_id = '$user_id' ORDER BY order_id DESC LIMIT 1");
    if ($latest_order && mysqli_num_rows($latest_order) > 0) {
        $row = mysqli_fetch_assoc($latest_order);
        $order_id = $row['order_id'];
    } else {
        header("Location: products.php");
        exit();
    }
}

// Fetch order details
$query = "SELECT * FROM orders WHERE order_id = '$order_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);
} else {
    header("Location: products.php");
    exit();
}
?>

<!-- Order Success CSS -->
<style>
    .order-success-section {
        width: 84%;
        margin: 60px auto;
        padding: 50px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        font-family: "Cinzel", serif;
    }

    .order-success-section h1 {
        font-size: 40px;
        color: #111;
        margin-bottom: 35px;
        text-align: center;
    }

    .success-box {
        width: 60%;
        margin: auto;
        padding: 35px;
        border: 1px solid #eee;
        border-radius: 20px;
        text-align: center;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        margin: auto;
        border-radius: 50%;
        background: green;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 45px;
        margin-bottom: 25px;
    }

    .success-box h2 {
        font-size: 28px;
        margin-bottom: 30px;
        color: #111;
    }

    .order-details {
        background: #fafafa;
        border: 1px solid #eee;
        border-radius: 15px;
        padding: 25px;
        text-align: left;
    }

    .order-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        font-size: 18px;
        border-bottom: 1px solid #eee;
    }

    .last-row {
        border-bottom: none;
    }

    .order-label {
        font-weight: 600;
    }

    .continue-btn {
        display: inline-block;
        width: 30%;
        margin-top: 30px;
        margin-right: 10px;
        padding: 14px;
        background: #fff;
        color: #000;
        text-align: center;
        text-decoration: none;
        border: 1px solid #000;
        border-radius: 30px;
        transition: 0.3s;
        font-size: 16px;
    }

    .continue-btn:hover {
        background: #000;
        color: #fff;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .order-success-section {
            width: 92%;
            padding: 30px 20px;
        }

        .order-success-section h1 {
            font-size: 32px;
        }

        .success-box {
            width: 100%;
            padding: 25px;
        }

        .order-row {
            font-size: 16px;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Order Success Section -->
<section class="order-success-section">
    <div class="success-box">
        <div class="success-icon">✔</div>
        <h2>Order Placed Successfully</h2>
        <div class="order-details">
            <div class="order-row">
                <span class="order-label">Order ID</span>
                <span>#ORD<?php echo htmlspecialchars($order['order_id']); ?></span>
            </div>

            <div class="order-row">
                <span class="order-label">Payment Mode</span>
                <span><?php echo htmlspecialchars($order['payment_method'] ?? 'Cash on Delivery'); ?></span>
            </div>

            <div class="order-row">
                <span class="order-label">Payment Status</span>
                <span><?php echo htmlspecialchars($order['payment_status']); ?> (Pay on Delivery)</span>
            </div>

            <div class="order-row last-row">
                <span class="order-label">Amount to Pay (₹100 Shipping Charges)</span>
                <span>₹<?php echo number_format(($order['amount'] ?? 0) + 100, 2); ?></span>
            </div>
        </div>

        <a href="my-orders.php" class="continue-btn"><i class="bi bi-bag-check me-2"></i>View Orders</a>
        <a href="index.php" class="continue-btn"><i class="bi bi-cart me-2"></i>Continue Shopping</a>
    </div>
</section>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>