<?php
    session_start();
    include 'assets/includes/db.php';

    // Redirect to login if user is not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Fetch user orders from database
    $orders_query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_id DESC";
    $orders_result = mysqli_query($conn, $orders_query);
?>

<!-- My Orders CSS -->
<style>
    .my-orders-section {
        width: 84%;
        margin: 60px auto;
        padding: 50px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .my-orders-section h1 {
        font-size: 40px;
        color: #111;
        margin-bottom: 35px;
        text-align: center;
        font-family: "Cinzel", serif;
    }

    .orders-box {
        width: 90%;
        margin: auto;
        padding: 35px;
        border: 1px solid #eee;
        border-radius: 20px;
    }

    .orders-box h2 {
        font-size: 28px;
        margin-bottom: 25px;
        color: #111;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table th {
        background: #fafafa;
        color: #111;
        padding: 16px;
        text-align: center;
        border-bottom: 1px solid #eee;
        font-size: 17px;
    }

    .orders-table td {
        padding: 16px;
        text-align: center;
        border-bottom: 1px solid #eee;
        font-size: 16px;
    }

    .orders-table tr:last-child td {
        border-bottom: none;
    }

    .status {
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        display: inline-block;
    }

    .pending {
        background: #fff3cd;
        color: #856404;
    }

    .processing {
        background: #cfe2ff;
        color: #084298;
    }

    .shipped {
        background: #e2d9f3;
        color: #59359a;
    }

    .delivered {
        background: #d1e7dd;
        color: #0f5132;
    }

    .cancelled {
        background: #f8d7da;
        color: #842029;
    }

    /* View Details Button */
    .view-btn {
        display: inline-block;
        padding: 9px 22px;
        background: #fff;
        color: #000;
        border: 1px solid #000;
        border-radius: 30px;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        text-align: center;
    }

    .view-btn:hover {
        background: #000;
        color: #fff;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .my-orders-section {
            width: 92%;
            padding: 30px 20px;
        }

        .my-orders-section h1 {
            font-size: 32px;
        }

        .orders-box {
            width: 100%;
            padding: 25px;
            overflow-x: auto;
        }

        .orders-table {
            min-width: 700px;
        }

        .view-btn {
            padding: 6px 14px;
            font-size: 12px;
            border-radius: 20px;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- My Orders -->
<section class="my-orders-section">
    <h1>My Orders</h1>
    <div class="orders-box">
        <h2>Order History</h2>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>View Details</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($orders_result && mysqli_num_rows($orders_result) > 0) {
                    while ($order = mysqli_fetch_assoc($orders_result)) {
                        
                        // Set order status CSS class
                        $status_class = 'pending';
                        $status_text = strtolower(isset($order['order_status']) ? $order['order_status'] : 'placed');

                        if ($status_text == 'processing') {
                            $status_class = 'processing';
                        } elseif ($status_text == 'shipped') {
                            $status_class = 'shipped';
                        } elseif ($status_text == 'delivered') {
                            $status_class = 'delivered';
                        } elseif ($status_text == 'cancelled') {
                            $status_class = 'cancelled';
                        } else {
                            $status_class = 'pending';
                        }

                        // Format order date
                        $order_date = isset($order['created_at']) ? date('d M Y', strtotime($order['created_at'])) : date('d M Y');
                ?>
                <tr>
                    <td>#ORD<?php echo htmlspecialchars($order['order_id']); ?></td>
                    <td><?php echo $order_date; ?></td>
                    <td>₹<?php echo number_format($order['amount']+ 100, 2); ?></td>
                    <td><?php echo htmlspecialchars($order['payment_method'] ?? 'Cash on Delivery'); ?></td>
                    <td>
                        <span class="status <?php echo $status_class; ?>">
                            <?php echo ucfirst(htmlspecialchars(isset($order['order_status']) ? $order['order_status'] : 'Placed')); ?>
                        </span>
                    </td>
                    <td>
                        <a href="order-details.php?id=<?php echo $order['order_id']; ?>" class="view-btn">View Details</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center py-4'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>