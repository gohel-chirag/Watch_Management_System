<?php
session_start();
include 'assets/includes/db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Redirect to checkout if address ID is missing
if (!isset($_SESSION['address_id'])) {
    header("Location: checkout.php");
    exit();
}

$user_id    = $_SESSION['user_id'];
$address_id = $_SESSION['address_id'];
$message    = "";

// Process order on confirm button click
if (isset($_POST['confirm_order'])) {
    
    // 1. Fetch customer details from address table
    $addr_query = "SELECT name, phone FROM user_addresses WHERE address_id = '$address_id' AND user_id = '$user_id'";
    $addr_res   = mysqli_query($conn, $addr_query);
    $addr_data  = mysqli_fetch_assoc($addr_res);

    $customer_name = $addr_data['name'] ?? '';
    $phone         = $addr_data['phone'] ?? '';

    // 2. Fetch cart items and total amount
    $cart_query = "SELECT c.quantity, w.watch_id, w.price 
                    FROM cart c 
                    JOIN watches w ON c.watch_id = w.watch_id 
                    WHERE c.user_id = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_query);

    if (mysqli_num_rows($cart_result) > 0) {
        $amount = 0;
        $items  = [];

        while ($row = mysqli_fetch_assoc($cart_result)) {
            $amount += ($row['price'] * $row['quantity']);
            $items[] = $row;
        }

        // 3. Insert record into orders table
        $payment_status = "Pending";
        $order_status   = "Placed";

        $insert_order = "INSERT INTO orders (user_id, address_id, customer_name, phone, amount, payment_status, order_status) 
                        VALUES ('$user_id', '$address_id', '$customer_name', '$phone', '$amount', '$payment_status', '$order_status')";

        if (mysqli_query($conn, $insert_order)) {
            $order_id = mysqli_insert_id($conn);

            // 4. Insert items into order_items and update stock
            foreach ($items as $item) {
                $w_id  = $item['watch_id'];
                $qty   = $item['quantity'];
                $price = $item['price'];

                mysqli_query($conn, "INSERT INTO order_items (order_id, watch_id, quantity, price) 
                                     VALUES ('$order_id', '$w_id', '$qty', '$price')");

                // Deduct item quantity from stock
                mysqli_query($conn, "UPDATE watches SET stock = stock - $qty WHERE watch_id = '$w_id'");
            }

            // 5. Clear user cart
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

            // Clear address session and store order ID
            unset($_SESSION['address_id']);
            $_SESSION['order_id'] = $order_id;

            header("Location: order-sucess.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Order placement failed: " . mysqli_error($conn) . "</div>";
        }
    } else {
        header("Location: cart.php");
        exit();
    }
}
?>

<!-- Payment CSS -->
<style>
    .payment-section {
        width: 84%;
        margin: 60px auto;
        padding: 50px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .payment-section h1 {
        font-size: 40px;
        color: #111;
        margin-bottom: 35px;
        text-align: center;
        font-family: "Cinzel", serif;
    }

    .payment-box {
        width: 60%;
        margin: auto;
        padding: 35px;
        border: 1px solid #eee;
        border-radius: 20px;
    }

    .payment-box h2 {
        font-size: 28px;
        margin-bottom: 25px;
        color: #111;
    }

    .payment-option {
        display: flex;
        gap: 15px;
        align-items: center;
        margin: 20px 0;
        font-size: 18px;
    }

    .payment-option input {
        width: 18px;
        height: 18px;
    }

    .cod-box {
        margin-top: 30px;
        padding: 25px;
        border-radius: 15px;
        background: #fafafa;
        border: 1px solid #eee;
        text-align: center;
    }

    .form-control {
        height: 45px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #000;
        box-shadow: none;
    }

    .pay-btn {
        display: inline-block;
        width: 100%;
        margin-top: 30px;
        padding: 14px;
        background: #fff;
        color: #000;
        text-align: center;
        text-decoration: none;
        border: 1px solid #000;
        border-radius: 30px;
        transition: 0.3s;
        cursor: pointer;
    }

    .pay-btn:hover {
        background: #000;
        color: #fff;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .payment-section {
            width: 92%;
            padding: 30px 20px;
        }

        .payment-section h1 {
            font-size: 32px;
        }

        .payment-box {
            width: 100%;
            padding: 25px;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Payment -->
<section class="payment-section">
    <h1>Payment</h1>
    <?php echo $message; ?>
    
    <div class="payment-box">
        <h2>Select Payment</h2>

        <form action="" method="POST">
            <div class="payment-option">
                <input type="radio" name="payment" value="COD" checked />
                <label>Cash on Delivery</label>
            </div>

            <div class="payment-option">
                <input type="radio" name="payment" disabled />
                <label>UPI (Currently Unavailable)</label>
            </div>

            <div class="payment-option">
                <input type="radio" name="payment" disabled />
                <label>Credit Card (Currently Unavailable)</label>
            </div>

            <!-- Cash on Delivery Details -->
            <div class="cod-box">
                <h2>Cash on Delivery</h2>
                <p>Pay with cash when your watch is delivered to your doorstep.</p>
                <ul style="text-align: left; margin-top: 15px; padding-left: 20px; font-size: 15px; color: #555;">
                    <li>Keep exact change ready at the time of delivery.</li>
                    <li>Cash payments only (no UPI or Cards at delivery).</li>
                    <li>Verify your order before making the payment.</li>
                </ul>
            </div>
            
            <button type="submit" name="confirm_order" class="pay-btn">Confirm Order</button>
        </form>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>