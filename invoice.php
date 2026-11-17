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

// Get Order ID from URL parameter, Session, or fetch latest order
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

// Fetch order details by joining orders and user_addresses tables
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

// Fetch order items and watch details
$items_query = "SELECT oi.*, w.watch_name as product_title, w.image as product_image 
                FROM order_items oi 
                LEFT JOIN watches w ON oi.watch_id = w.watch_id 
                WHERE oi.order_id = '$order_id'";
$items_result = mysqli_query($conn, $items_query);
?>
<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rolex - Invoice</title>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/Images/favicon.png">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .invoice-card {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        /* Header / Brand */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #111;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .brand-name {
            font-family: 'Cinzel', serif;
            font-size: 28px;
            font-weight: 700;
            color: #000;
            letter-spacing: 1px;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            text-align: right;
        }

        /* Top Meta Details */
        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafafa;
            padding: 15px 20px;
            border-radius: 8px;
            border: 1px solid #eee;
            margin-bottom: 25px;
        }

        .order-id {
            font-size: 18px;
            font-weight: 700;
            color: #111;
        }

        .order-date {
            font-size: 14px;
            color: #555;
        }

        .status-badge {
            background: #fff8e1;
            color: #b78103;
            border: 1px solid #ffe082;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Section Titles */
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        /* Items Table */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .product-table th {
            background: #f8f8f8;
            text-align: left;
            padding: 12px;
            font-size: 13px;
            color: #444;
            border-bottom: 1px solid #ddd;
        }

        .product-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .product-info-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 4px;
        }

        /* Grid Section for Address & Summary */
        .info-grid {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-box {
            flex: 1;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 18px;
        }

        .address-text p {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }

        /* Summary Row */
        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 8px;
            color: #555;
        }

        .summary-row.total {
            font-size: 16px;
            font-weight: 700;
            color: #000;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
            margin-top: 10px;
        }

        /* Print Actions */
        .print-action-box {
            text-align: center;
            margin-top: 20px;
        }

        .btn-print {
            border: 1px solid #000;
            color: #fff;
            background: #000;
            border-radius: 30px;
            padding: 12px 32px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            background: #333;
            border-color: #333;
        }

        /* Print Stylesheet */
        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }

            .invoice-card {
                border: none;
                box-shadow: none;
                padding: 0;
                width: 100%;
                max-width: 100%;
            }

            .print-action-box {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="invoice-card">
    <!-- Invoice Header -->
    <div class="invoice-header">
        <div>
            <div class="brand-name">Rolex</div>
            <small style="color: #777;">Luxury Watch Store</small>
        </div>
        <div>
            <div class="invoice-title">INVOICE</div>
        </div>
    </div>

    <!-- Order Meta -->
    <div class="meta-row">
        <div>
            <div class="order-id">Order #ORD<?php echo htmlspecialchars($order['order_id']); ?></div>
            <div class="order-date"><i class="bi bi-calendar3"></i> Order Date: <?php echo isset($order['created_at']) ? date('d M Y', strtotime($order['created_at'])) : date('d M Y'); ?></div>
        </div>
        <div>
            <span class="status-badge"><i class="bi bi-hourglass-split"></i> <?php echo ucfirst(htmlspecialchars(isset($order['order_status']) ? $order['order_status'] : 'Processing')); ?></span>
        </div>
    </div>

    <!-- Product Information -->
    <div class="section-title">Product Information</div>
    <table class="product-table">
        <thead>
            <tr>
                <th>Item Details</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $items_subtotal = 0;
            if ($items_result && mysqli_num_rows($items_result) > 0) {
                while ($item = mysqli_fetch_assoc($items_result)) {
                    $item_price = isset($item['price']) ? $item['price'] : 0;
                    $item_qty = isset($item['quantity']) ? $item['quantity'] : 1;
                    $items_subtotal += ($item_price * $item_qty);

                    // Dynamic image source checking
                    if (!empty($item['product_image'])) {
                        $img_src = $item['product_image'];
                    } elseif (!empty($item['item_image'])) {
                        $img_src = $item['item_image'];
                    } else {
                        $img_src = 'assets/Images/default-watch.jpg';
                    }
            ?>
            <tr>
                <td>
                    <div class="product-info-cell">
                        <img src="assets/Images/watches/<?php echo htmlspecialchars($item['product_image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($item['product_title']); ?>" class="product-img" onerror="this.src='https://via.placeholder.com/60'">
                        <div>
                            <strong><?php echo htmlspecialchars(isset($item['product_title']) ? $item['product_title'] : 'Product'); ?></strong>
                        </div>
                    </div>
                </td>
                <td style="text-align: center;"><?php echo $item_qty; ?></td>
                <td style="text-align: right; font-weight: 600;">₹<?php echo number_format($item_price * $item_qty, 2); ?></td>
            </tr>
            <?php 
                }
            } else {
                $items_subtotal = isset($order['amount']) ? $order['amount'] : 0;
            ?>
            <tr>
                <td>
                    <div class="product-info-cell">
                        <img src="assets/Images/default-watch.jpg" alt="Product" class="product-img" onerror="this.src='https://via.placeholder.com/60'">
                        <div>
                            <strong>Ordered Item</strong>
                        </div>
                    </div>
                </td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right; font-weight: 600;">₹<?php echo number_format($items_subtotal, 2); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Address & Summary Section -->
    <div class="info-grid">
        <!-- Shipping Address -->
        <div class="info-box">
            <div class="section-title">Shipping Address</div>
            <div class="address-text">
                <?php if (!empty($order['name'])): ?>
                    <p><strong><?php echo htmlspecialchars($order['name']); ?></strong></p>
                <?php endif; ?>

                <?php if (!empty($order['address'])): ?>
                    <p><?php echo htmlspecialchars($order['address']); ?></p>
                <?php endif; ?>

                <p>
                    <?php 
                        $city = !empty($order['city']) ? htmlspecialchars($order['city']) : '';
                        $state = !empty($order['state']) ? htmlspecialchars($order['state']) : '';
                        echo implode(', ', array_filter([$city, $state]));
                    ?>
                </p>

                <?php if (!empty($order['pincode'])): ?>
                    <p>Pincode: <?php echo htmlspecialchars($order['pincode']); ?></p>
                <?php endif; ?>

                <?php if (!empty($order['phone'])): ?>
                    <p><i class="bi bi-telephone me-1"></i> <?php echo htmlspecialchars($order['phone']); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="info-box">
            <div class="section-title">Payment Summary</div>
            <div class="summary-row">
                <span>Item Price</span>
                <span>₹<?php echo number_format($items_subtotal, 2); ?></span>
            </div>
            <div class="summary-row">
                <span>Shipping Charge</span>
                <span>₹<?php echo isset($order['shipping_charge']) ? number_format($order['shipping_charge'], 2) : '100.00'; ?></span>
            </div>
            <div class="summary-row">
                <span>Payment Method</span>
                <span><strong><?php echo htmlspecialchars(isset($order['payment_method']) ? $order['payment_method'] : 'COD'); ?></strong></span>
            </div>
            <div class="summary-row total">
                <span>Total Amount</span>
                <span>₹<?php echo isset($order['amount']) ? number_format($order['amount']+100, 2) : number_format($items_subtotal, 2); ?></span>
            </div>
        </div>
    </div>

    <!-- Print Invoice Button -->
    <div class="print-action-box">
        <button class="btn-print" onclick="window.print();">
            <i class="bi bi-printer me-2"></i> PRINT INVOICE
        </button>
    </div>
</div>

</body>
</html>